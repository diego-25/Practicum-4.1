import './bootstrap';
import $ from 'jquery';

window.Alpine = Alpine;


window.$ = window.jQuery = $;

Alpine.start();


$(function () {

    function loadChildren($parent, attr, $child) {
        const id  = $parent.val();
        if (!id) {
            $child.html('<option disabled selected>— Seleccione —</option>').trigger('change');
            return;
        }

        const url = $parent.data(attr).replace(':id', id);
        $.getJSON(url, function (items) {
            let opts = '<option disabled selected>— Seleccione —</option>';
            $.each(items, (_, it) => opts += `<option value="${it.value}">${it.text}</option>`);
            $child.html(opts);

            const oldVal = $child.data('old');
            if (oldVal) { $child.val(oldVal).data('old', null); }
            $child.trigger('change');
        });
    }

    $('#idObjetivo').on('change', function () {
        loadChildren($(this), 'programa-route', $('#idPrograma'));
    });

    $('#idPrograma').on('change', function () {
        loadChildren($(this), 'plan-route', $('#idPlan'));
    });

    if (document.body.dataset.old === '1') {
        $('#idObjetivo').trigger('change');
    }
});