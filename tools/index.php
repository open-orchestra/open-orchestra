<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
    <title>Purge Varnish cache</title>
</head>

<style type="text/css">
    body {
        font-size: 10px;
    }
    h1 {
        font-weight: bold;
        color: #000000;
        border-bottom: 1px solid #C6EC8C;
        margin-bottom: 2em;
    }
    label {
        font-size: 160%;
        float: left;
        text-align: right;
        margin-right: 0.5em;
        display: block
    }
    input[type="text"] {
        width: 500px;
    }
    .submit input {
        margin-left: 0em;
        margin-bottom: 1em;
    }
</style>

<body>

<h1>Makes Varnish purge the supplied URL from its cache</h1>

<form action="purgeVarnish.php" method="post">
    <p><label>HOST</label> <input type="text" name="host"></p>
    <p class="submit"><input value="Submit" type="submit"></p>
</form>

</body>
</html>
