Alpine.data('select2', (el, wire, wireModel, url, passedData) => {
    let ajaxData = null;

    if (url) {
        ajaxData = {
            url: url,
            dataType: 'json',
            delay: 100,
            data: function (params) {
                let requestData = {
                    q: params.term,
                };
    
                if (passedData && passedData['selectedCity']) {
                    console.log('test' + passedData['selectedCity']);
                    requestData.city = wire.get(passedData['selectedCity']);
                    console.log('test' + requestData.city);
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
        };
    }

    $(el).select2({
        placeholder: passedData['placeholder'] ?? null,
        language: {
            noResults: function () {
                return passedData['not_found'];
            }
        },
        ajax: ajaxData,
        minimumInputLength: 0
    });


    let modelValue = wire.get(wireModel);

    if (modelValue && url) {
        $.ajax({
            url: url+`/${modelValue}`, // API для отримання конкретного міста
            dataType: 'json'
        }).done(function (item) {
            let option = new Option(item.name, item.id, true, true);
            $(el).append(option).trigger('change');
        });
    }

    $(el).on('change', function (e) {
        wire.set(wireModel, e.target.value);
    });
});