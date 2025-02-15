Alpine.data('select2', (el, wire, wireModel) => {
    $(el).select2();

    $(el).on('change', function (e) {
        wire.set(wireModel, e.target.value);
    });
});