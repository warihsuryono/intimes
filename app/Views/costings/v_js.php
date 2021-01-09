<script>
    <?php if (isset($costing)) : ?>
        $("[name='item_id']").val("<?= $costing->item_id; ?>");
        $("[name='code']").val("<?= $costing->code; ?>");
        $("[name='item_specification_id']").val("<?= $costing->item_specification_id; ?>");
        $("[name='item_category_id']").val("<?= $costing->item_category_id; ?>");
        $("[name='item_sub_category_id']").val("<?= $costing->item_sub_category_id; ?>");
        $("[name='item_type_id']").val("<?= $costing->item_type_id; ?>");
        $("[name='item_name']").val("<?= $costing->item_name; ?>");
        $("[name='volume_budget']").val("<?= $costing->volume_budget; ?>");
        $("[name='volume_unit_id']").val("<?= $costing->volume_unit_id; ?>");
        $("[name='cost_currency_id']").val("<?= $costing->cost_currency_id; ?>");
        $("[name='cost_budget']").val("<?= $costing->cost_budget; ?>");
        $("[name='revenue_currency_id']").val("<?= $costing->revenue_currency_id; ?>");
        $("[name='revenue']").val("<?= $costing->revenue; ?>");
        setTimeout(function() {
            load_scopes("<?= $costing->item_type_id; ?>", [<?= str_replace("|", "", str_replace("||", ",", $costing->item_scope_ids)); ?>]);
        }, 500);
    <?php endif ?>

    $(document).ready(function() {
        setTimeout(function() {
            $("[name='item_scope_ids[]']").multiselect({
                buttonWidth: '100%',
                enableFiltering: false,
                maxHeight: 300
            });
        }, 500);
    });

    function load_scopes(item_type_id, selected) {
        selected = selected || [];
        $("[name='item_scope_ids[]']").html("<option value=''>Loading, please wait ...</option>");
        $("[name='item_scope_ids[]']").multiselect('rebuild');
        $.get("<?= base_url(); ?>/item_scope/scopes_by_type_id/" + item_type_id, function(result) {
            var scopes = JSON.parse(result);
            options = "";
            for (var ii = 0; ii < scopes.length; ii++) {
                options += "<option value=" + scopes[ii].id + ">" + scopes[ii].name + " " + scopes[ii].unit + "</option>";
            }
            $("[name='item_scope_ids[]']").html(options);
            $("[name='item_scope_ids[]']").multiselect('rebuild');
            $("[name='item_scope_ids[]']").multiselect('select', selected);
        });
    }
</script>