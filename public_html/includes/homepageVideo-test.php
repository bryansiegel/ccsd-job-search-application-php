<?php
// Fetch current Unix timestamp
$current_time = time();

// Check if the current time is within the board meeting time range
if ($current_time > 1732649514 && $current_time < 1732649514) {
    // NORMAL BOARD MEETING
    if ($live_board_meeting) { ?>
        <section class="live-stream-notification">
            <!-- Default titles and links -->
            <p><strong>CCSD Live Stream</strong><br>
                View the stream on <a href="https://ccsd.eduvision.tv/live.aspx" target="_blank">Eduvision</a>
                or <a href="https://www.youtube.com/channel/UCb8dUIsat7U7lTjXYPFs_Ww" target="_blank">YouTube</a>
            </p>
            <div class="board-meeting-disclaimer">
                If you're having trouble viewing the live stream, call 702-799-2988
            </div>
            <div id="spanish-off" class="dynamic-content">&nbsp;</div>
        </section>
    <?php }
} elseif ($is_spanish) {
    // SPANISH LINKS
    ?>
    <section class="live-stream-notification">
        <!-- Default titles and links -->
        <p><strong>CCSD Live Stream</strong><br>
            View the stream on <a href="https://ccsd.eduvision.tv/live.aspx" target="_blank">Eduvision</a>
            or <a href="https://www.youtube.com/channel/UCb8dUIsat7U7lTjXYPFs_Ww" target="_blank">YouTube</a>
        </p>
        <div class="board-meeting-disclaimer">
            If you're having trouble viewing the live stream, call 702-799-2988
        </div>
        <!-- Spanish Links -->
        <div id="spanish-on" class="dynamic-content">
            <strong>Español:</strong>
            <a href="https://ccsd.eduvision.tv/LiveChannelPlayer.aspx?qev=6zseFFegtzjNZq8essXM9Q%253d%253d" target="_blank">Eduvision</a>
            <p class="board-meeting-disclaimer">
                Si tiene problemas con el link en español, llame al (702) 855-9646 y use la clave 776225 para acceder a la junta exclusivamente con audio.
                Por favor ponga su teléfono en silencio cuando entre la llamada.
            </p>
        </div>
    </section>
    <?php
}
?>
