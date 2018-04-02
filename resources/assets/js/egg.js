/**
 * Run an Egg program
 * @see https://eloquentjavascript.net/12_language.html
 * @see https://gist.github.com/wldcordeiro/2ec9aeb4e3fa512eec26
 */

const specialForms = Object.create(null);

function evaluate(expr, scope) {
    if (expr.type == "value") {
        return expr.value;
    } else if (expr.type == "word") {
        if (expr.name in scope) {
            return scope[expr.name];
        } else {
            throw new ReferenceError(
                `Undefined binding: ${expr.name}`);
        }
    } else if (expr.type == "apply") {
        let {operator, args} = expr;
        if (operator.type == "word" &&
            operator.name in specialForms) {
            return specialForms[operator.name](expr.args, scope);
        } else {
            let op = evaluate(operator, scope);
            if (typeof op == "function") {
                return op(...args.map(arg => evaluate(arg, scope)));
            } else {
                throw new TypeError("Applying a non-function.");
            }
        }
    }
}

specialForms.if = (args, scope) => {
    if (args.length != 3) {
        throw new SyntaxError("Wrong number of args to if");
    } else if (evaluate(args[0], scope) !== false) {
        return evaluate(args[1], scope);
    } else {
        return evaluate(args[2], scope);
    }
};

specialForms.while = (args, scope) => {
    if (args.length != 2) {
        throw new SyntaxError("Wrong number of args to while");
    }
    while (evaluate(args[0], scope) !== false) {
        evaluate(args[1], scope);
    }

    // Since undefined does not exist in Egg, we return false,
    // for lack of a meaningful result.
    return false;
};

specialForms.do = (args, scope) => {
    let value = false;
    for (let arg of args) {
        value = evaluate(arg, scope);
    }
    return value;
};

specialForms.local = (args, scope) => {
    if (args.length != 2 || args[0].type != "word") {
        throw new SyntaxError("Incorrect use of local");
    }
    let value = evaluate(args[1], scope);
    scope[args[0].name] = value;
    return value;
};

specialForms.set = (args, scope) => {
    if (args.length != 2 || args[0].type != 'word') {
        throw new SyntaxError('Incorrect use of set');
    }

    const valName = args[0].name;
    const value = evaluate(args[1], scope);
    for (let scopeUp = scope; scopeUp; scopeUp = Object.getPrototypeOf(scopeUp)) {
        if (Object.prototype.hasOwnProperty.call(scopeUp, valName)) {
            scopeUp[valName] = value;
            return value;
        }
    }
    throw new ReferenceError(`Tried setting an undefined variable: ${valName}`);
};

specialForms.incr = (args, scope) => {
    if (args.length != 1 || args[0].type != "word") {
        throw new SyntaxError("Incorrect use of incr");
    }
    scope[args[0].name] += 1;
    return scope[args[0].name];
};

specialForms.decr = (args, scope) => {
    if (args.length != 1 || args[0].type != "word") {
        throw new SyntaxError("Incorrect use of decr");
    }
    scope[args[0].name] -= 1;
    return scope[args[0].name];
};

specialForms.even = (args, scope) => {
    if (args.length != 1) {
        throw new SyntaxError("Incorrect use of even");
    }
    let value = evaluate(args[0], scope);
    return value % 2 == 0;
};

specialForms.odd = (args, scope) => {
    if (args.length != 1) {
        throw new SyntaxError("Incorrect use of odd");
    }
    let value = evaluate(args[0], scope);
    return value % 2 != 0;
};

specialForms.fun = (args, scope) => {
    if (!args.length) {
        throw new SyntaxError("Functions need a body");
    }
    let body = args[args.length - 1];
    let params = args.slice(0, args.length - 1).map(expr => {
        if (expr.type != "word") {
            throw new SyntaxError("Parameter names must be words");
        }
        return expr.name;
    });

    return function() {
        if (arguments.length != params.length) {
            throw new TypeError("Wrong number of arguments");
        }
        let localScope = Object.create(scope);
        for (let i = 0; i < arguments.length; i++) {
            localScope[params[i]] = arguments[i];
        }
        return evaluate(body, localScope);
    };
};

let topScope = {
    true: true,
    false: false,
    print: value => {
        console.log(value);
        return value;
    },
    random: value => {
        return Math.floor(Math.random() * value);
    },
    array: function() {
        var args = Array.prototype.slice.call(arguments, 0);
        return args;
    },
    length: function(array) {
        return array.length;
    },
    element: function(array, n) {
        return array[n];
    }
};

for (let op of ["+", "-", "*", "/", "%", "==", "<", ">"]) {
    topScope[op] = Function("a, b", `return a ${op} b;`);
}

module.exports = {
    topScope,
    run: function (program, scope) {
        return evaluate(program, scope);
    }
};