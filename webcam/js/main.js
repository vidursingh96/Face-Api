//const video = document.getElementById('facecam')

/*Promise.all([
  faceapi.nets.tinyFaceDetector.loadFromUri('./models'),
  faceapi.nets.faceLandmark68Net.loadFromUri('./models'),
  faceapi.nets.faceRecognitionNet.loadFromUri('./models'),
  faceapi.nets.faceExpressionNet.loadFromUri('./models')
]).then(startVideo)*/

/*function startVideo() {
  navigator.mediaDevices.getUserMedia({video: {}}).then((stream)=> {video.srcObject = stream;}, (err)=> console.error(err));
}*/

function number_test(n){
    var result = (n - Math.floor(n)) !== 0; 
    return result;
}

/*video.addEventListener('playing', () => {
  const canvas = faceapi.createCanvasFromMedia(video)
  document.body.append(canvas)

  const displaySize = { width: video.width, height: video.height }
  faceapi.matchDimensions(canvas, displaySize)
  setInterval(async () => {
    const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
    const resizedDetections = faceapi.resizeResults(detections, displaySize)
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
    if(detections.length>0){
        var data = {};
        Object.keys(detections[0].expressions).forEach(function(key){
            let expval = detections[0].expressions[key];
            value = new Number(expval);
            data[key] = value.toFixed(14);
        });
        console.log(data);
        var x = Object.keys(data).reduce(function(a, b){ return data[a] > data[b] ? a : b });
        var xval = Number(data[x]);
        document.getElementById('ExpName').value = x
        document.getElementById('ExpValue').value = xval.toFixed(2);
        document.getElementById('submit').style.display = "inline-block";
    }
    faceapi.draw.drawDetections(canvas, resizedDetections)
    faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
    faceapi.draw.drawFaceExpressions(canvas, resizedDetections)
  }, 100)
});*/