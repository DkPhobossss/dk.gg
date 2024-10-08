<html>
<body>
<h1>Localization for aghanims and skills</h1>

<? if (!empty( $this->success ) ) : ?>
    <h2>DONE.</h2>
<? endif; ?>

<form enctype="multipart/form-data" method="post" action="">
    <input type="file" accept=".txt" name="doc">
    <div>
        <input type="submit" value="Upload" name="submit">
    </div>
</form>
</body>
</html>