<?php

/**
 * Plugin Name: WP-Zoltar
 * Plugin URI:  https://github.com/gwannon/wp-zoltar/
 * Description: Shortcode para montar un Adivino Zoltar que de buenas fortunas. [zoltar]Texto fortuna 1|Texto fortuna 2|...|Texto fortuna 10[/zoltar]
 * Version:     1.0
 * Author:      Gwannon
 * Author URI:  https://github.com/gwannon/
 * License:     GNU General Public License v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-zoltar
 *
 * PHP 7.3
 * WordPress 6.1.1
 */


//Shortcode ------------------
function wpZoltarShortcode($params = array(), $content = null) {
  global $post;
  ob_start(); ?> 
  <link href="https://fonts.googleapis.com/css2?family=Aladin&display=swap" rel="stylesheet">
  <style>
    #zoltar {
      max-width: 600px;
      position: relative;
      margin: auto;
      --animation-duration: 1s;
      --main-color: <?=( isset($params['main-color']) && $params['main-color'] !='' ? $params['main-color'] : '#008aab');?>;
      --secondary-color: <?=( isset($params['secondary-color']) && $params['secondary-color'] !='' ? $params['secondary-color'] : '#fdd756');?>;
    }

    /* ----------- Color --------------- */
    #zoltar .zoltar-cls-10,
    #zoltar .zoltar-cls-11,
    #zoltar .zoltar-cls-12,
    #zoltar .zoltar-cls-13,
    #zoltar .tarjeta-cls-1,
    #zoltar .tarjeta-cls-2 {
      fill: var(--main-color);
    }

    #zoltar .zoltar-cls-2,
    #zoltar .zoltar-cls-6,
    #zoltar .zoltar-cls-7 {
      fill: var(--secondary-color);
    }

    #zoltar .tarjeta-cls-2 {
      stroke: var(--main-color);
    }

    /* ----------- Boca --------------- */
    #boca {
      width: 12.5%;
      position: absolute;
      top: 52.3%;
      left: 44.9%;
    }

    #boca.start {
      animation: openmouth 1.5s infinite alternate;
    }

    @keyframes openmouth {
      to { top: 55%; }
    }

    /* ----------- Ojos --------------- */
    #zoltar.start .eyes {
      animation: glowingeyes calc(var(--animation-duration) * 1.5) infinite alternate-reverse;
    }

    @keyframes glowingeyes {
      to { fill: #fff; }
    }

    /* ----------- Tobogan --------------- */
    #tobogan {
      width: 29.5%;
      position: absolute;
      top: 32.3%;
      right: -1.5%;
      z-index: 10;
    }

    /* ----------- Botón --------------- */
    #boton {
      width: 15%;
      position: absolute;
      top: 81%;
      right: 42%;
      z-index: 10;
      cursor: pointer;
    }

    #boton .cls-boton-1 {
      animation: glowingbutton var(--animation-duration) infinite alternate;
    }

    #boton.off .cls-boton-1 {
      fill: #8c2333;
      animation: none;
    }

    @keyframes glowingbutton {
      to { fill: #8c2333; }
    }

    /* ----------- Moneda --------------- */
    #moneda {
      width: 15%;
      position: absolute;
      top: 30%;
      right: 0%;
    }

    #moneda.start {
      animation: movex var(--animation-duration) 1 linear,
      movey var(--animation-duration) 1 cubic-bezier(.3,-.04,.12,1.3),
      rotating calc(var(--animation-duration) / 5) 5 linear,
      shrink var(--animation-duration) 1 linear;
    }

    @keyframes movex {
      to { right: 47%; }
    }

    @keyframes movey {
      to { top: 53%; }
    }

    @keyframes rotating {
      to { transform: rotate(-360deg); }
    }

    @keyframes shrink {
      to { width: 3%; }
    }

    /* ----------- Explosión --------------- */
    #explosion {
      width: 28%;
      top: 46%;
      right: 35%;
      position: absolute;
      opacity: 0;
    }

    #explosion.clink {
      animation: fadeinexplosion var(--animation-duration) linear;
    }

    @keyframes fadeinexplosion {
      30% { opacity: 1; }
      100% { opacity: 1; }
    }

    /* ----------- Marcador --------------- */
    #marcador {
      position: absolute;
      top: 26.5%;
      right: 3%;
      font-size: 20px;
      font-family: 'Aladin', cursive;
      color: #ffd864;
    }

    @media (min-width: 600px) {
      #marcador { font-size: 30px; }
    }

    /* ----------- Tarjeta --------------- */
    #tarjeta {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0%;
      transform-origin: center;
      z-index: 20;
    }

    #tarjeta.start {
      animation: rotatingcard calc(var(--animation-duration) * 0.5) 1 linear forwards,
      enbiggencard calc(var(--animation-duration) * 0.5) 1 linear forwards;
    }

    @keyframes rotatingcard {
      to { transform: rotate(-360deg); }
    }

    @keyframes enbiggencard {
      to {
        left: 0%;
        top: 30%;
        width: 100%;
      }
    }

    #tarjeta > div {
      position: absolute;
      top: 0px;
      left: 0px;
      height: 100%;
      display: flex;
      align-content: center;
      flex-wrap: wrap;
      justify-content: center;
      align-items: center;
    }

    #tarjeta > div > p {
      text-align: center;
      font-size: 30px;
      opacity: 0;
      font-family: 'Aladin', cursive;
      color: var(--main-color);
      line-height: 110%;
      padding: 10%;
    }

    @media (min-width: 600px) {
      #tarjeta > div > p {
        font-size: 40px;
      }
    }

    #tarjeta.start > div > p {
      animation: showtext calc(var(--animation-duration) * 0.2) 1 linear forwards;
      animation-delay: calc(var(--animation-duration) * 0.5);
    }

    @keyframes showtext {
      to { opacity: 1; }
    }
  </style>
  <div id="zoltar" class="start">
    <?php echo file_get_contents(WP_PLUGIN_DIR . "/wp-zoltar/piezas/zoltar.svg"); ?>
    <div id="boca" class="start"><?php echo file_get_contents(WP_PLUGIN_DIR . "/wp-zoltar/piezas/boca.svg"); ?></div>
    <div id="tobogan"><?php echo file_get_contents(WP_PLUGIN_DIR . "/wp-zoltar/piezas/tobogan.svg"); ?></div>
    <div id="boton"><?php echo file_get_contents(WP_PLUGIN_DIR . "/wp-zoltar/piezas/boton.svg"); ?></div>
    <div id="moneda"><?php echo file_get_contents(WP_PLUGIN_DIR . "/wp-zoltar/piezas/moneda.svg"); ?></div>
    <div id="tarjeta"><?php echo file_get_contents(WP_PLUGIN_DIR . "/wp-zoltar/piezas/tarjeta.svg"); ?><div><p></p></div></div>
    <div id="marcador">x3</div>
    <div id="explosion"><?php echo file_get_contents(WP_PLUGIN_DIR . "/wp-zoltar/piezas/explosion.svg"); ?></div>
  </div>
  <script>
    jQuery( document ).ready(function() {
      var fortunes = [
        <?php echo "'".str_replace("|", "',\n'", $content)."'"; ?>
      ];
      var marcador = 3;
      var current = 0;
      const gua = new Audio("<?php echo plugin_dir_url(__FILE__); ?>piezas/gua-gua-gua.mp3" );
      const monedarodando = new Audio("<?php echo plugin_dir_url(__FILE__); ?>piezas/moneda.mp3" );
      const exito = new Audio("<?php echo plugin_dir_url(__FILE__); ?>piezas/exito.mp3" );
      const metal = new Audio("<?php echo plugin_dir_url(__FILE__); ?>piezas/metal.mp3" );
      jQuery("#boton").click(function() {
        if(current < 3) {
          monedarodando.play();        
          jQuery("#moneda").addClass("start");
          jQuery("#explosion").removeClass("clink");
          let height = jQuery("#zoltar").outerHeight();
          setTimeout(function(){
            jQuery("#moneda").removeClass("start");
            let percent = parseInt(jQuery("#boca").css("top")) * 100 / height;
            if (percent > 54) { //
              let rand = Math.floor(Math.random() * fortunes.length);
              current = 3;
              jQuery("#tarjeta > div > p").html(fortunes[rand]);
              jQuery("#tarjeta").addClass("start");
              jQuery("#marcador").html("x0");
              exito.play();
            } else  {
              current++;
              marcador--;
              jQuery("#marcador").html("x" + marcador);
              if(current < 3) {
                jQuery("#explosion").addClass("clink");
                metal.play();
              } else if(current == 3) {
                jQuery("#explosion").addClass("clink");
                metal.play();
                setTimeout(function(){
                  jQuery("#boca,#zoltar").removeClass("start");
                  jQuery("#boton").addClass("off");
                  gua.play();
                }, 1000);
              }
            }
          }, 1000);
        }
      });
    });
  </script>
  <?php return ob_get_clean();
}
add_shortcode('zoltar', 'wpZoltarShortcode');
