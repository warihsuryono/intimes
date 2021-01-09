<script>
    $("#add-row").click(function() {
        var coa = "<select class='form-control' name='coa[]'>";
        <?php foreach ($coas as $coa) : ?>
            coa += "<option value='<?= $coa->coa; ?>'><?= $coa->coa; ?> -- <?= $coa->description; ?></option>";
        <?php endforeach ?>
        coa += "</select>";
        var notes = "<input class='form-control' name='notes[]'>";
        var debit = "<input type='number' step='0.1' class='form-control' style='text-align:right;' name='debit[]' onkeyup='calculate()'>";
        var credit = "<input type='number' step='0.1' class='form-control' style='text-align:right;' name='credit[]' onkeyup='calculate()'>";
        var markup = "<tr>";
        markup += "<td><a class='btn btn-default' onclick = \" $(this).parents('tr').remove();\"> <i class = 'fas fa-trash-alt'> </i></a></td>";
        markup += "<td>" + coa + "</td>";
        markup += "<td>" + notes + "</td>";
        markup += "<td>" + debit + "</td>";
        markup += "<td>" + credit + "</td>";
        markup += "</tr>";
        $("#journal_details_body").append(markup);
    });
    <?php if (isset($journal)) : ?>
        $("[name='journal_at']").val("<?= $journal->journal_at; ?>");
        $("[name='invoice_no']").val("<?= $journal->invoice_no; ?>");
        $("[name='currency_id']").val("<?= $journal->currency_id; ?>");
        $("[name='description']").val("<?= $journal->description; ?>");
        $("[name='bank_id']").val("<?= $journal->bank_id; ?>");
    <?php endif ?>
    <?php if (isset($journal_details) && count($journal_details) > 0) : ?>
        <?php foreach ($journal_details as $key => $journal_detail) : ?>
            $("#add-row").click();
            $("#journal_details_body").find('select[name="coa[]"]')[<?= $key; ?>].value = "<?= $journal_detail->coa; ?>";
            $("#journal_details_body").find('input[name="notes[]"]')[<?= $key; ?>].value = "<?= $journal_detail->notes; ?>";
            $("#journal_details_body").find('input[name="debit[]"]')[<?= $key; ?>].value = "<?= $journal_detail->debit; ?>";
            $("#journal_details_body").find('input[name="credit[]"]')[<?= $key; ?>].value = "<?= $journal_detail->credit; ?>";
        <?php endforeach ?>
        calculate();
    <?php endif ?>

    function calculate() {
        var total_debit = 0;
        var total_credit = 0;
        var ii = -1;
        $("#journal_details_body").find('input[name="debit[]"]').each(function() {
            ii++;
            total_debit = total_debit + ($(this).val() * 1);
            total_credit = total_credit + ($("#journal_details_body").find('input[name="credit[]"]')[ii].value * 1);
        });
        var balance = total_debit - total_credit;
        $("[name='total_debit']").val(total_debit);
        $("[name='total_credit']").val(total_credit);
        $("[name='balance']").val(balance);
    }
</script>