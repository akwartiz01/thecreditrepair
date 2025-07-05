<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Agreement</title>
    <!--<script src="https://cdn.tiny.cloud/1/hb9hjij7vk83j4ikn0c6b92b6azc7g9nwbk0fhb1bpvy6niq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>-->
    <script>
        tinymce.init({
            selector: '#agreement_text'
        });
    </script>
</head>

<body>

    <h2>Add New Agreement</h2>
    <form method="post" action="<?= base_url('client/AgreementController/save_agreement') ?>">
        <label for="agreement_text">Agreement Text:</label>
        <textarea id="agreement_text" name="agreement_text" rows="10"></textarea><br><br>

        <label for="is_default">Set as Default:</label>
        <input type="checkbox" name="is_default" value="1"><br><br>

        <button type="submit">Save Agreement</button>
    </form>

</body>

</html>