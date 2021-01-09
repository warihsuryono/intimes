<script>
    <?php if (isset($item)) : ?>
        $("[name='code']").val("<?= $item->code; ?>");
        $("[name='item_specification_id']").val("<?= $item->item_specification_id; ?>");
        $("[name='item_category_id']").val("<?= $item->item_category_id; ?>");
        $("[name='item_sub_category_id']").val("<?= $item->item_sub_category_id; ?>");
        $("[name='item_type_id']").val("<?= $item->item_type_id; ?>");
        $("[name='item_brand_id']").val("<?= $item->item_brand_id; ?>");
        $("[name='name']").val("<?= $item->name; ?>");
        $("[name='unit_id']").val("<?= $item->unit_id; ?>");
        $("[name='stock_min']").val("<?= $item->stock_min; ?>");
        $("[name='stock_max']").val("<?= $item->stock_max; ?>");
        setTimeout(function() {
            load_scopes("<?= $item->item_type_id; ?>", [<?= str_replace("|", "", str_replace("||", ",", $item->item_scope_ids)); ?>]);
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