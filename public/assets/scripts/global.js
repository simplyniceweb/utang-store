$(document).ready(function(){
    var f = {};

    $.fn.modal.Constructor.prototype._enforceFocus = function() {};

    f.addCreditItem = function() {
        $('.add-item').on('click', function(){
            var clone = $('.input-group.clone').clone(),
                id = f.makeid(8);

            clone = clone.removeClass('clone').attr('id', id);
            $('.input-group.clone').after(clone);

            f.itemSelect(id);
            f.calculateAmount();
            f.removeCreditItem();
        });
    };

    f.removeCreditItem = function() {
        $('.remove-item').off();
        $('.remove-item').on('click', function(){
            if ($('#exampleModal .input-group').length <= 2) {
                alert('Need atleast 1 item.');

                return false;
            }
            if (confirm('Are you sure you want to remove this item?')) {
                $(this).parent().remove();
            }
        });
    };

    f.userSelect = function() {
        $('.user-credit').select2({
            minimumInputLength: 3,
            dropdownParent: $('#exampleModal'),
            minimumResultsForSearch: 10,
            placeholder: "Search user",
            ajax: {
                url: location.origin+'/user-list',
                dataType: 'json',
                type: "GET",
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.name
                            }
                        })
                    };
                }
            }
        });
    };

    f.itemSelect = function(clone) {
        var toSelect = !clone ? $('#cccjferrer .select-item') : $('#'+clone+' .select-item');

        toSelect.select2({
            minimumInputLength: 3, 
            minimumResultsForSearch: 10,
            placeholder: "Search item",
            dropdownParent: $('#exampleModal'),
            ajax: {
                url: location.origin+'/inventory-list',
                dataType: 'json',
                type: "GET",
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.name,
                                store_price: item.store_price
                            }
                        })
                    };
                }
            }
        });

        f.selectItem();
    };

    f.selectItem = function() {
        $('.select-item').off();
        $('.select-item').on('select2:select', function(event) {
            var data = event.params.data;
            $(this).parent().find('.price').attr('value', data.store_price );
        })
    };

    f.calculateAmount = function() {
        $('.modal input.amount').off();
        $('.modal input.price').off();

        $('.modal input.amount').on('focusout', function(){
            console.log('called');
            var total = $('.total-amount');
            total.attr('value', 0);

            $('.modal .item-list:not(.clone)').each(function(){
                amount = $(this).find('.amount'),
                amountValue = parseInt(amount.val()),
                price = $(this).find('.price'),
                priceValue = parseFloat(price.val()),
                totalValue = parseFloat(total.val());

                if (!amountValue) {
                    return;
                }

                console.log(amountValue, priceValue, totalValue);

                total.attr('value', (priceValue*amountValue)+totalValue);
            });
        });

        $('.modal input.price').on('focusout', function(){
            $('.modal input.amount').each(function(){
                $(this).trigger('focusout');
                
                return true;
            });
        });
    };

    f.makeid = function(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }

        return result;
    }

    f.redirectToDebtDetails = function()
    {
        $('.info-box').on('click', function(){
            window.location.href = $(this).data('id');
        });
    };

    f.deleteDebtConfirmation = function() {
        return $('.delete-debt').on('click', function(){
            if (confirm('Are you sure you want to delete this debt item?')) {
                var link = $(this).find('a').attr('href');

                window.location.href = link;
            }
        });
    }

    $('#exampleModal').on('shown.bs.modal', function (e) {
        f.userSelect();
        f.itemSelect();
        f.calculateAmount();
    });

    if ($('.static-item').length > 0) {
        f.itemSelect();
        f.calculateAmount();
    }

    f.addCreditItem();
    f.removeCreditItem();
    f.redirectToDebtDetails();
    f.deleteDebtConfirmation();
});