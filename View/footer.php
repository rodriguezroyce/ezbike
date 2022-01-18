 <script>
var clickCount = 0;
$('#dropdownMenuButton').click(function() {
    clickCount++;
    if (clickCount % 2 == 0) {
        $('.dropdown-menu').fadeOut("fast");
    } else {
        $('.dropdown-menu').fadeIn("slow");
        $('.dropdown-menu').mouseover(() => {
            $('.dropdown-menu').show("fast");

        });
    }


});
 </script>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
 </script>

 </body>

 </html>