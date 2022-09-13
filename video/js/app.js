(async () => {
    await faceapi.nets.ssdMobilenetv1.loadFromUri('./models');
    await faceapi.nets.faceLandmark68Net.loadFromUri('./models');
    await faceapi.nets.faceExpressionNet.loadFromUri('./models');
    
    const image = document.querySelector('#blah');
    const canvas = faceapi.createCanvasFromMedia(image);
    const detections = await faceapi.detectAllFaces(image)
                                    .withFaceLandmarks()
                                    .withFaceExpressions();
                            
    if(detections.length>0){
        var data = {};
        Object.keys(detections[0].expressions).forEach(function(key){
            let expval = detections[0].expressions[key];
            value = new Number(expval);
            data[key] = value.toFixed(14);
        });
        var x = Object.keys(data).reduce(function(a, b){ return data[a] > data[b] ? a : b });
        var xval = Number(data[x]);
        let valExp = xval.toFixed(2);
        document.getElementById('nextBtn').href = "image.php?faceExpValue="+valExp + "&faceExpName=" +x;
        document.getElementById('faceExpName').value = x
        document.getElementById('faceExpValue').value = valExp;
        document.getElementById('submit').style.display = "inline-block";
    }

    const dimensions = {
        width: image.width,
        height: image.height
    };

    const resizedDimensions = faceapi.resizeResults(detections, dimensions);
   
    faceapi.draw.drawDetections(canvas, resizedDimensions);
    faceapi.draw.drawFaceLandmarks(canvas, resizedDimensions);
    faceapi.draw.drawFaceExpressions(canvas, resizedDimensions);
    
    document.body.append(canvas);
    
})();