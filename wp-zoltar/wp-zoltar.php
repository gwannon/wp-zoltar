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
  <?php /* <script src="https://code.jquery.com/jquery-3.6.2.min.js"></script> */ ?>
  <style>
    #zoltar {
      max-width: 600px;
      position: relative;
      margin: auto;
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
      to {
        top: 55%;
      }
    }

    /* ----------- Ojos --------------- */
    #zoltar.start .eyes {
      animation: glowingeyes 1.5s infinite alternate-reverse;
    }

    @keyframes glowingeyes {
      to {
        fill: #fff;
      }
    }

    /* ----------- Tobogan --------------- */
    #tobogan {
      width: 29.5%;
      position: absolute;
      top: 32.3%;
      right: -1.5%;
      z-index: 10;
      /*transform: rotate(6deg);*/
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
      animation: glowingbutton 1s infinite alternate;
    }

    #boton.off .cls-boton-1 {
      fill: #8c2333;
      animation none;
    }

    @keyframes glowingbutton {
      to {
        fill: #8c2333;
      }
    }

    /* ----------- Moneda --------------- */
    #moneda {
      width: 15%;
      position: absolute;
      top: 30%;
      right: 0%;
      --animation-duration: 1s;
    }

    #moneda.start {
      animation: movex var(--animation-duration) 1 linear,
      movey var(--animation-duration) 1 cubic-bezier(.3,-.04,.12,1.3),
      rotating calc(var(--animation-duration) / 5) 5 linear,
      shrink var(--animation-duration) 1 linear;
    }

    @keyframes movex {
      to {
        right: 47%;
      }
    }

    @keyframes movey {
      to {
        top: 53%;
      }
    }

    @keyframes rotating {
      to {
        transform: rotate(-360deg);
      }
    }

    @keyframes shrink {
      to {
        width: 3%;
      }
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
      animation: fadeinexplosion 1s linear
    }

    @keyframes fadeinexplosion {
      30% {
        opacity: 1;
      }
      100% {
        opacity: 1;
      }
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
      #marcador {
        font-size: 30px;
      }
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
      animation: rotatingcard 0.5s 1 linear forwards,
      enbiggencard 0.5s 1 linear forwards;
    }

    @keyframes rotatingcard {
      to {
        transform: rotate(-360deg);
      }
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
      color: #008aab;
      line-height: 110%;
      padding: 10%;
    }

    @media (min-width: 600px) {
      #tarjeta > div > p {
        font-size: 40px;
      }
    }

    #tarjeta.start > div > p {
      animation: showtext 0.2s 1 linear forwards;
      animation-delay: 0.5s;
    }

    @keyframes showtext {
      to {
        opacity: 1;
      }
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
    var fortunes = [
      <?php echo "'".str_replace("|", "',\n'", $content)."'"; ?>
    ];
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
        var height = jQuery("#zoltar").outerHeight();
        setTimeout(function(){
          jQuery("#moneda").removeClass("start");
          var top = parseInt(jQuery("#boca").css("top"));
          var percent = top * 100 / height;
          if (percent > 54) { //
            var rand = Math.floor(Math.random() * fortunes.length);
            exito.play();
            jQuery("#tarjeta > div > p").html(fortunes[rand]);
            jQuery("#tarjeta").addClass("start");
            current = 3;
            jQuery("#marcador").html("x0");
          } else  {
            current++;
            var marcador = 3 - current;
            jQuery("#marcador").html("x" + marcador);
            if(current < 3) {
              metal.play();
              jQuery("#explosion").addClass("clink");
            } else if(current == 3) {
              jQuery("#boca").removeClass("start");
              jQuery("#zoltar").removeClass("start");
              jQuery("#boton").addClass("off");

              gua.play();
            }
          }
        }, 1000);
      }
    });
  </script>
<?php $html = ob_get_clean(); 
  return $html;
}
add_shortcode('zoltar', 'wpZoltarShortcode');
