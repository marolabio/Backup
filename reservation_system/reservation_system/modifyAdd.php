<!DOCTYPE html>
<?php
  include_once 'includes/dbh.inc.php';
  include_once 'includes/header-login.inc.php';
  session_start();

?>

  <script type="text/javascript">
    $(document).ready(function(){

    $(function(){
      
        $('#checkin').datepicker({ minDate: 3,  dateFormat: 'yy-mm-dd',
      
      onSelect: function() {
        var date = $(this).datepicker('getDate');
        if (date){
          date.setDate(date.getDate() + 1);
          $( "#checkout" ).datepicker( "option", "minDate", date );
        }
      }     
      });

      
      $('#checkout').datepicker({ minDate: 1, dateFormat: 'yy-mm-dd'});
      
    });

    (function($){


    

        function processForm( e ){

            $("#show").hide();
            $("#response").hide();
            $("#wait").css("display", "block");
            
            $.ajax({
                url: 'modifyAddLoad.php',
                dataType: 'text',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                data: $(this).serialize(),
                success: function( data, textStatus, jQxhr ){
                    $("#wait").css("display", "none");
                    $("#response").show();
                    $('#response').html( data );
                    
                setInterval(function(){
                 $("#response").load("modifyAddLoad.php");
                }, 5000);
                                          
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            });

          //setTimeout(function(){ alert("The page has expired due to inactivity. Click OK to reload page."); window.location.reload();}, 120000);

            e.preventDefault();
        }


       $('#my-form').submit( processForm );

    })(jQuery);
  });
  </script>
  </head>
<body>
 
  <br>
  <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            
            <div class="well">
      <form id ="my-form">
        <div class = "form-group">
          <label> Check-in:</label>
          <input type="text" class = "form-control" name = "checkin" id="checkin" placeholder="Check-in" required />
        </div>
        <div class = "form-group">
          <label> Check-out:</label>
          <input type = "text" class = "form-control" name = "checkout" id = "checkout" placeholder="Check-out" required />
        </div>
        <button type="submit" name = "submit" class="btn btn-default btn-block search">Search</button>
        </div>
      </form>

        </div>

          <div class="col-md-9">
            <!-- Website Overview -->
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                 <h3 class="panel-title" style = "text-align: center;">Available Rooms</h3>
              </div>
              <div class="panel-body">

            <h1 id = "show" style = "text-align: center;">Please select dates</h1>

            <div id = "wait" style = "display:none; ">
                <div style = "text-align:center;">
                    <img src="img/Preloader_2.gif" alt="Preloader" width="67" height="67" ><br>Loading, please wait...
                </div>
                
            </div>

            <div id = "response"></div>
              
                

              </div>
              </div>

          </div>
        </div>
      </div>
    </section>





    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

  </body>
</html>
