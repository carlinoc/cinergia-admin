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
    const url = `https://www.googleapis.com/youtube/v3/videos?id=${videoId}&key=${apiKey}&part=snippet,contentDetails`;

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

