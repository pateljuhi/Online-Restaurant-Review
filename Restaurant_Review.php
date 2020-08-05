<?php
  include "./Lab5Common/header.php"; 
	$restaurants = simplexml_load_file('restaurant_review.xml');
?>
<!-- <script type="text/javascript" src="./restaurant_review.js"></script> -->
<h1>Online Restaurant Review</h1>
<table border="0" display="visible" id="t1">
   <tr>
      <td>Restaurant:</td>
      <td>
         <select id="restaurant">
            <option value="-1">Select...</option>
            <?php
            $restro = $restaurants->restaurant;
            foreach($restro AS $rest) 
            {
                  print ("<option value = '$rest->name' " . ($_POST['restaurant'] == $rest->name ? 'selected' : '') ." >" . $rest->name ." </option>");
            }
            ?>
         </select>
      <span name="error" id="error"></span></td>
   </tr>
</table>

<div class="container">
   <div class="row">
      <div class="col s3">
         <label for="address">Address</label>
      </div>
      <div class="col s4">
         <textarea id="address" cols="50" rows="10" disabled></textarea>
      </div>
   </div>
   <div class="row">
      <div class="col s3">
         <label for="summary">Summary</label>
      </div>
      <div class="col s4">
         <textarea id="summary" cols="50" rows="10"></textarea>
      </div>
   </div>
   <div class="row">
      <div class="col s3">
         <label for="rating">Rating</label>
      </div>
      <div class="col s4">
         <select id ='rating' name ='rating' min ='1' max ='5' >
         <?php 
         	for($i = 1; $i <= 5; $i++){
               print ("<option value='$i'>". $i ."</option>");
            }
         ?> 
         </select>
     </div>
   </div>
   <div class="row">
      <div class="col s3">
        <button type="submit" id="saveBtn">Submit</button>
      </div>
      <div></div>
   </div>
</div>

<?php include "./Lab5Common/footer.php"; ?>
<script>
   $('#restaurant').on('change', function() {
      $.ajax({
         method: "POST",
         url: "Server.php",
         data: {
            selectedRestName: $(this).val()
         }
      })
      //.done (function(responce){....});
      .done(response => {
         const json = JSON.parse(response);
         // const address = json.address; 
         // const summary = json.summry; 
         // const rating = json.rating;  short way to write these 3 lines
         const { address, summary, rating } = json;

         $('#address').text(address);
         $('#summary').text(summary);
         $('#rating').val(rating);
      });
   });
// submit btn

$('#saveBtn').on('click', function() {
      $.ajax({
         method: "POST",
         url: "Server.php",
         data: {
            restName : $('#restaurant').val(),
            newSummary : $('#summary').val(),
            newRating : $('#rating').val()
         }
      })
      .done(response => {
        
      });
   });

</script>
