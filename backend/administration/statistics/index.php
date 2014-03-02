<?php

	/* /statistics/index.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 *	Erstellt das Formular für die Hilfe
	 *
	 */
	 
include("../../../config.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/other/statistics.php");

if (!($_SESSION['rights']['root'])){
	header("Location: ".RELATIVE_ROOT."/");
	exit();
}

$temp = get();
$os=$temp[1];
$browser = $temp[0];
$classes = $temp[2];
$sections = $temp[3];
$sitesSub = $temp[4];
$hourFrequenzy = $temp[5];
$mobileWeb = $temp[6];
//Seitenheader
pageHeader("Statistiken","main");
?>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/jquery.jqplot.min.css" />
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    var s1 = [ <?php echo $browser; ?>];
         
    var plot1 = $.jqplot('chart1', [s1], {
	title:'Browser',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
    var s2 = [ <?php echo $os; ?>];
         
    var plot2 = $.jqplot('chart2', [s2], {
	title:'Plattform',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
    var s3 = [ <?php echo $classes; ?>];
         
    var plot3 = $.jqplot('chart3', [s3], {
	title:'Sch&uuml;ler/Lehrer',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
    var s4 = [ <?php echo $sections; ?>];
         
    var plot4 = $.jqplot('chart4', [s4], {
	title:'Abteilungen',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
    var s5 = [ <?php echo $sitesSub; ?>];
         
    var plot5 = $.jqplot('chart5', [s5], {
	title:'Seiten Supplierungen',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
    var s6 = [ <?php echo $mobileWeb; ?>];
         
    var plot6 = $.jqplot('chart6', [s6], {
	title:'Seiten Supplierungen',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
  var s7 = [ <?php echo $hourFrequenzy; ?>];
  var plot7 = $.jqplot('chart7', [s7], { 
      series:[{showMarker:false}],
      title:'Aufrufe/Stunde',
      axes:{
        xaxis:{
          label:'Stunden',
	  min: 0,
	  max: 23,
	  ticks: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],
          labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
          tickOptions: {
		formatString: '%i',
          },
	  labelOptions: {
            fontFamily: 'Georgia, Serif',
            fontSize: '12pt',
	    textColor: '#FFF',
          }
        },
        yaxis:{
	  min: 0,
          labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
          labelOptions: {
            fontFamily: 'Georgia, Serif',
            fontSize: '12pt',
	    textColor: 'white',
          }
        },
	seriesDefaults:{
        	rendererOptions:{
				smooth: true,
		},
            pointLabels:{ 
            	show: true 
            	},
            showMarker:false, 
            color: '#4BB2C5'
        },
      }
  });
});
</script>
<?php
printf("<div  id=\"chart1\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart2\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart3\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart4\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart5\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart6\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart7\" style=\"height:400px;width:1200px;float:left;\"></div>");
//Seitenfooter



pageFooter();


?>
