var scenes = {!! json_encode($story->scenes()) !!};
let scope = egg.topScope;

function show(scene) {

    if (typeof scene.shown === 'undefined' || scene.shown === false) {
        $.each(scene.vars, function (name, value) { scope[name] = value; });
    }
    
    $('#scene h5').remove();
    if (typeof scene.vars.show_title === 'undefined' || scene.vars.show_title) {
        $('<h5 class="card-title"></h5>')
            .text(scene.title)
            .prependTo('#scene .card-body');
    }

    $('#scene img[class=card-img-top]').remove();
    if (typeof scene.vars.image !== 'undefined') {
        $('#scene').prepend('<img class="card-img-top" src="' + scene.vars.image + '">');
    }

    let body = scene.body;

    scene.code.forEach(function (code, i) {
        const result = egg.run(code, scope);
        body = body.replace('<code #' + (i+1).toString() + '>', result);
    });

    $('#scene p').html(body.replace(/\n/g, '<br>'));

    $('#scene ul').html('');
    scene.passages.forEach(function (passage, i) {

        let condition = true;
        if (typeof passage.condition !== 'undefined') {
            condition = egg.run(passage.condition, scope);
        }
        if (condition) {
            let action = typeof passage.action !== 'undefined'
                ? passage.action : {};

            $('<li><a id="passage-' + i + '" data-target="'
                + passage.target
                + '" href="#">'
                + passage.title + '</a></li>')
                .appendTo('#scene ul');

            $('#passage-' + i).data('action', action);
        }
    });
    scene.shown = true;
}

$('#passages').on('click', 'a', function (e) {
    e.preventDefault();

    const target = $(this).data('target');

    const action = $(this).data('action');
    egg.run(action, scope);

    if (typeof scenes[target] === 'undefined') {
        var $msg = $('<div class="alert alert-danger">Szene <strong>' + target + '</strong> nicht gefunden</div>');
        $msg.insertBefore('#scene');
        setTimeout(function () {
            $msg.fadeOut();
        }, 2000);
    }
    else {
        show(scenes[target]);
    }
});

$('#start-story').on('click', function (e) {
    e.preventDefault();
    show(scenes[Object.keys(scenes)[0]]);
});

show(scenes[Object.keys(scenes)[0]]);
