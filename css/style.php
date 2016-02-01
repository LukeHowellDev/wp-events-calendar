<?php
header("Content-type: text/css");
?>
/* Large Styles */
.large-calendar {width:100%; border-collapse:collapse;}
.large-calendar tr.navigation th {padding-bottom:20px;}
.large-calendar th.prev-month {text-align:left;}
.large-calendar th.current-month {text-align:center; font-size:1.5em;}
.large-calendar th.next-month {text-align:right;}
.large-calendar tr.weekdays th {text-align:left;}
.large-calendar td {width:14%; height:100px; vertical-align:top; border:1px solid #CCC;}
.large-calendar td.today {background:#FFD;}
.large-calendar td.prev-next {background:#EEE;}
.large-calendar td.prev-next span.date {color:#9C9C9C;}
.large-calendar td.holiday {background:#DDFFDE;}
.large-calendar span.date {display:block; padding:4px; line-height:12px; background:#EEE;}
.large-calendar div.day-content {}
.large-calendar ul.output {margin:0; padding:0 4px; list-style:none;}
.large-calendar ul.output li {margin:0; padding:5px 0; line-height:1em; border-bottom:1px solid #CCC;}
.large-calendar ul.output li:last-child {border:0;}