Alpine.data('select2', (el, wire, wireModel, url, passedData) => {
    if (url) {
        $(el).select2({
            ajax: {
                url: url,
                dataType: 'json',
                delay: 100,
                data: function (params) {
                    let requestData = {
                        q: params.term,
                    };

                    if (passedData && passedData['selectedCity']) {
                        requestData.city = wire.get(passedData['selectedCity']);
                    }

                    if (passedData && passedData['relatedOnly']) {
                        requestData.relatedOnly = passedData['relatedOnly'];
                    }

                    return requestData;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.name
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 0
        });
    } else {
        $(el).select2();
    }

    $(el).on('change', function (e) {
        wire.set(wireModel, e.target.value);
    });
});