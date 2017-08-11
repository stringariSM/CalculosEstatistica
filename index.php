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

        <div class="col-sm-10">
            <input type="text" class="form-control" name="numeros" id="numeros">
        </div>
        <div class="col-sm-2">
            <input type="text" class="form-control col-sm-2" name="repetir" id="repetir" value="1">
        </div>

        <div class="col-sm-12">
            <br/>
        </div>

        <div class="col-sm-12">
            <button type="button" class="btn btn-block btn-primary">Enviar</button>
        </div>
    </form>
    <br/>
    <div id="results" class="col-sm-12">

    </div>
    <script>
        $(document).ready(function(){
            $("button").on("click", function(e){
                var numeros = $("#numeros").val();
                var repetir = $("#repetir").val();

                var i = 0;
                var numerosRepetidos = "";
                while(i < repetir){
                    if(numerosRepetidos) {
                        numerosRepetidos = numerosRepetidos + '-' + numeros;
                    }else{
                        numerosRepetidos = numeros;
                    }
                    console.log(numerosRepetidos);
                    i++;
                }

                //e.preventDefault();
                $.ajax({
                    url: "calculos.php",
                    data: {'numeros': numerosRepetidos},
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


