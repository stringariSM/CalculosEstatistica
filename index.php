<html>
<head>
    <meta charset="UTF-8"/>
    <title>Estatística</title>
    <script
            src="_lib/jquery2.2.4/jquery-2.2.4.min.js"></script>

    <link href="_lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="_lib/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <form action="calculos.php" method="POST" class="form">
        <label class="col-sm-12">Número separados por "-": </label>
        <div class="input-group col-sm-12">
            <input type="text" class="form-control" style="100%" name="numeros" id="numeros">
        </div>
        <br/>
        <button type="button" class="btn btn-block btn-primary">Enviar</button>
    </form>
    <div id="results">

    </div>
    <script>
        $(document).ready(function(){
            $("button").on("click", function(e){
                //e.preventDefault();
                $.ajax({
                    url: "calculos.php",
                    data: {'numeros': $("#numeros").val()},
                    method: "POST"
                }).done(function(json) {
                    var table = $("<table>", {class:"table table-striped"});

                    var trC = $("<tr>");
                    var th1 = $("<th>").text("Descrição");
                    var th2 = $("<th>").text("Resultado");

                    trC.append(th1);
                    trC.append(th2);
                    table.append(trC);

                    $.each($.parseJSON(json), function(idx, obj) {
                        var tr = $("<tr>");
                        var tdTitle = $("<td>").text(obj.title);
                        var tdValue = $("<td>").text(obj.value);

                        tr.append(tdTitle);
                        tr.append(tdValue);
                        table.append(tr);
                    });
                    $("#results").html(table);
                    //$("#results").append(table);
                });
            });
        });
    </script>
</div>
</body>
</html>
<?php


