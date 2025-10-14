<?php
	

// $live_board_meeting = 1;

//NON-VEGAS PBS SPECIAL EVENT
if (date('U') > 1703271407  && date('U') < 1703271407) { ?>
<!-- 1627591623 -->
<?php }
//VEGASPBS SPECIAL EVENT
elseif (date('U') > 1703271407 && date('U') < 1703271407) { 
    if ($live_board_meeting) { ?>
	<?php } 
}
//NORMAL BOARD MEETING
else {
    if ($live_board_meeting) { ?>
		<section class="live-stream-notification">
			



<!-- Default titles and links -->
<p><strong>CCSD Live Stream</strong> <br>	
<!--
	<strong><strong>2022-2023 State of the Schools!</strong> <br>	</strong> <br>	
View the stream on <a href="https://www.eduvision.tv/l?eOetOOR" target="_blank">Eduvision</a> 
-->	     
View the stream on <a href="https://ccsd.eduvision.tv/live.aspx" target="_blank">Eduvision</a> 


or <a href="https://www.youtube.com/channel/UCb8dUIsat7U7lTjXYPFs_Ww" target="_blank" >YouTube</a>
</p>
 <div class="board-meeting-disclaimer">If you're having trouble viewing the live stream, call 702-799-2988</div> 
 	<div id="spanish-off" class="dynamic-content">
	 	&nbsp;
 	</div>
 <!-- Spanish Links. - turn on for Board meeting -->
 		<div id="spanish-on" class="dynamic-content">
	 <!--    <div class="board-meeting-disclaimer-spanish"><p>If you have problems with the link in Spanish, call (702) 855-9646 and use code 776225 to access the meeting exclusively with audio.</p> -->
		
		<strong>Español:</strong> <a href="https://ccsd.eduvision.tv/LiveChannelPlayer.aspx?qev=6zseFFegtzjNZq8essXM9Q%253d%253d" target="_blank">Eduvision</a></p>


        <p class="board-meeting-disclaimer">Si tie ne problemas con el link en español, llame al (702) 855-9646 y use la clave 776225 para accesar la junta exclusivamente con audio. Por favor ponga su teléfono en silencio cuando entre la llamada.</p>
        </div>
        
        </div>

<!--Unhide this section - for Technical Issues -->

<!--         <div class="board-meeting-disclaimer">We are experiencing technical difficulties and are working on the problem. Thank you for your patience.</div> -->
       
<!--          <div class="board-meeting-disclaimer">Estamos experimentando dificultades técnicas y estamos trabajando en el problema. Gracias por su paciencia.</div> -->



		</section>
		

 
<!-- Old Facebook Link -->
<!--or <a href="https://www.facebook.com/ClarkCountySchoolDistrict/live/" target="_blank">Facebook</a>




		
	<?php }
}
?>



