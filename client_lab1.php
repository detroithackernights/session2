<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>

    <body>
        <div class="container-fluid" style="position:absolute; left:80px; top:200px;">
            <div class="row">
                <div class="col-lg-6" id="lookupdiv">
                    <input type="text" id="userid">
                </div>
                <div class="col-lg-6" id="resultsdiv">
                    <input type="textbox" id="results">
                </div>
            </div>
        </div>

    </body>

<script>

$('#userid').bind('input', function() {
    //Call the Restful Service

    userid =  $('#userid').val()
     $.ajax({
        type: "GET",
        url: "services_lab2.php/Person/" + userid,
        dataType: "json",
        success: function(msg){
            name = msg.AllUsers.Firstname + " " + msg.AllUsers.Lastname;
            console.log(msg.AllUsers);
           $('#results').val(name);
         }
    });


})


</script>


</html>