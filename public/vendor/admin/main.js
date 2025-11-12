function slugify(str) {
    return String(str)
      .normalize('NFKD')
      .replace(/[\u0300-\u036f]/g, '')
      .trim()
      .toLowerCase()
      .replace(/[^a-z0-9 -]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-');
}

function emptyfy(elements) {
    let message='';
    let _element=null;
    for (i=0; i<elements.length; i++) {
        if(document.getElementById(elements[i][0]).value==''){
            message += '- ' + elements[i][1] + '<br>';
            if(_element==null){
                _element = document.getElementById(elements[i][0]);
            }
        }
    }
    if(_element != null){
      _element.focus();
      Swal.fire({
        title: "Atención",
        html: message,
        icon: "warning",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Aceptar"
      });
      return false;
    }
    return true;
}

function getFormattedDate(date) {
    let year = date.getFullYear();
    let month = (1 + date.getMonth()).toString().padStart(2, '0');
    let day = date.getDate().toString().padStart(2, '0');

    return month + '/' + day + '/' + year;
}

async function fetchYouTubeVideoDetails(videoId) {
    const apiKey =  YT_API_KEY;
    const url = `https://www.googleapis.com/youtube/v3/videos?id=${videoId}&key=${apiKey}&part=snippet,contentDetails,status`;

    try {
        const response = await fetch(url);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching YouTube video details:', error);
    }
}

function isNotNaNGlobal(value) {
  return !isNaN(value);
}

function youtubeDurationToMinutes(duration) {
  // Expresión regular para extraer horas, minutos y segundos
  const match = duration.match(/PT(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?/);

  if (!match) return 0;

  const hours = parseInt(match[1] || "0", 10);
  const minutes = parseInt(match[2] || "0", 10);
  const seconds = parseInt(match[3] || "0", 10);

  // Convertir todo a minutos
  const totalMinutes = hours * 60 + minutes + seconds / 60;

  // Redondear al número entero más cercano
  return Math.round(totalMinutes);
}

function showErrorMsg(message){
  Swal.fire({
      title: "Atención",
      html: message,
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Aceptar"
  });
}

function showSuccessMsg(message){
  Swal.fire({
      title: "Muy bien",
      html: message,
      icon: "success",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Aceptar"
  });
}

function showAlertMsg(message){
  Swal.fire({
      title: "Atención",
      html: message,
      icon: "warning",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Aceptar"
  });
}

function checkYouTubePlayable(videoId, timeoutMs = 3000) {
    return new Promise((resolve) => {
        const containerId = "yt-player-check";
        // Crear contenedor temporal (oculto)
        const tempDiv = document.createElement("div");
        tempDiv.id = containerId;
        tempDiv.style.width = "1px";
        tempDiv.style.height = "1px";
        tempDiv.style.position = "absolute";
        tempDiv.style.left = "-9999px";
        document.body.appendChild(tempDiv);

        let timer = null;
        let resolved = false;
        let player = null;

        function cleanUp() {
            if (timer) {
                clearTimeout(timer);
                timer = null;
            }
            try {
                if (player && player.destroy) player.destroy();
            } catch (e) { /* noop */ }
            const el = document.getElementById(containerId);
            if (el) el.remove();
        }

        function finish(result) {
            if (resolved) return;
            resolved = true;
            cleanUp();
            resolve(result);
        }

        function onPlayerError(event) {
            // Mapear códigos de error
            let reason = "Error desconocido";
            switch (event.data) {
                case 2: reason = "ID de video no válido"; break;
                case 100: reason = "El video fue eliminado o es privado"; break;
                case 101:
                case 150: reason = "El propietario bloqueó la reproducción en sitios externos"; break;
            }
            finish({ playable: false, reason });
        }

        function onPlayerStateChange(event) {
            // 1 -> PLAYING, 3 -> BUFFERING, 5 -> VIDEO_CUED
            if (event.data === YT.PlayerState.PLAYING) {
                finish({ playable: true });
            }
            // si recibe error se maneja por onPlayerError
        }

        function attemptPlay() {
            try {
                // Intentar reproducir. Si autoplay está bloqueado, puede que no pase a PLAYING.
                player.playVideo();
            } catch (e) {
                // Si falla la llamada, consideramos no reproducible
                finish({ playable: false, reason: "No se pudo iniciar la reproducción (excepción)." });
                return;
            }

            // Si en timeout no hubo PLAYING ni ERROR, consideramos bloqueado
            timer = setTimeout(() => {
                // Si no se resolvió aún, lo marcamos como no reproducible
                if (!resolved) {
                    finish({
                        playable: false,
                        reason: "No se pudo reproducir el video en este sitio (posible bloqueo por derechos o autoplay bloqueado)."
                    });
                }
            }, timeoutMs);
        }

        function createPlayer() {
            player = new YT.Player(containerId, {
                videoId: videoId,
                playerVars: {
                    'controls': 1,
                    'rel': 0,
                    'playsinline': 1
                },
                events: {
                    onReady: function() {
                        // Intentar reproducir al estar listo
                        attemptPlay();
                    },
                    onError: onPlayerError,
                    onStateChange: onPlayerStateChange
                }
            });
        }

        // Si la API ya está disponible
        if (window.YT && window.YT.Player) {
            createPlayer();
        } else {
            const prev = window.onYouTubeIframeAPIReady;
            window.onYouTubeIframeAPIReady = function() {
                if (typeof prev === 'function') prev();
                createPlayer();
            };
        }
    });
}

