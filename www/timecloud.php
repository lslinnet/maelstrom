<?php
$timeconstraint;
if(isset($_GET['start'])) {
   $timeconstraint="&start=".$_GET['start'];
}
if(isset($_GET['end'])) {
   $timeconstraint.="&end=".$_GET['end'];
}
?>
<html>
   <head>
      <script src="jquery.js" type="text/javascript" charset="utf-8"></script>
      <script src="jquery.sparkline.js" type="text/javascript" charset="utf-8"></script>
      <script type="text/javascript" src="ui.core.js"></script>
      <script type="text/javascript" src="ui.slider.js"></script>
      <script type="text/javascript" src="tagcloud.js"></script>
      <script type="text/javascript" src="maelstrom.js"></script>
      <script type="text/javascript" src="timecloud.js"></script>
      <script type="text/javascript">
         var play=0;
         function togglePlay(obj) {
            if(play) { play=false; obj.val(">");
            } else { play=true; obj.val("||"); animate(); }
         }

         $(document).ready(function() {
            $("#pause").click(function () { togglePlay($(this)); });
            $("#step").click(function () { animate(); });
            var query="mailyze.php?op=mailFrequency<?php print $timeconstraint;?>";
            $.getJSON(query,function(data) { drawSparkline(data,'#overviewGraph',sparklineStyle)});
            var cend=toSliderScale(window_size);
            $('#slide').slider({ handles: [{start: 0, id:'handle1'}, {start: cend, id:'handle2'}],
                                 range: true, change: function(e,ui) { console.log(ui.range); } });
            var query="mailyze.php?op=contactTimeCloud<?php print $timeconstraint;?>";
            $.getJSON(query,loadTimecloud);
         })
      </script>
      <link href="style.css" rel="stylesheet" type="text/css" />
   </head>
   <body>
      <div id="content">
         <div id="header">
            <h1>TimeCloud</h1>
            <input type="submit" id="pause" value=">" />
            <input type="submit" id="step" value="+" />
         </div>
         <div id="overviewGraph" class="timegraph">
            <div class="sparkline" > </div>
            <div class="dates">
               <span class="enddate" ></span>
               <span class="startdate"></span>
            </div>
            <div id="slide" class="ui-slider">
              <div id="handle1" class="ui-slider-handle"></div>
              <div id="handle2" class="ui-slider-handle"></div>
            </div>
         </div>
         <div id="zoomGraph" class="timegraph">
            <div class="sparkline" > </div>
            <div class="dates">
               <div class="enddate"></div>
               <div class="startdate"></div>
            </div>
         </div>
         <div id="tagcloud"></div>
      </div>
   </body>
</html>