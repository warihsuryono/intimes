<script>
    <?php if (isset($item)) : ?>
        $("[name='code']").val("<?= $item->code; ?>");
        $("[name='item_specification_id']").val("<?= $item->item_specification_id; ?>");
        $("[name='item_category_id']").val("<?= $item->item_category_id; ?>");
        $("[name='item_sub_category_id']").val("<?= $item->item_sub_category_id; ?>");
        $("[name='item_type_id']").val("<?= $item->item_type_id; ?>");
        $("[name='name']").val("<?= $item->name; ?>");
        $("[name='unit_id']").val("<?= $item->unit_id; ?>");
        $("[name='address']").val("<?= str_replace(chr(13) . chr(10), "<br>", $item->address); ?>".replace("<br>", "\n").replace("<br>", "\n").replace("<br>", "\n").replace("<br>", "\n"));
        $("[name='city']").val("<?= $item->city; ?>");
        $("[name='province']").val("<?= $item->province; ?>");
        $("[name='lat']").val("<?= $item->lat; ?>");
        $("[name='lon']").val("<?= $item->lon; ?>");
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