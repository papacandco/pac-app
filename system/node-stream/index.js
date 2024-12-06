const express = require('express');
const fs = require('fs');
const path = require('path');
const PORT = 9010;
const app = express();
const cors = require('cors');
const mime = require("mime");
const BASE_DIRECTORY = path.join(__dirname, process.env.STORAGE_PATH || "../../storage/app/public");

app.use(cors());

app.use(function (req, res, next) {
  res.setHeader("Accept-Ranges", "bytes");
  return next();
});

app.get('/stream', function(req, res) {
  try {
    const target = req.query.target;
    const source = req.query.source;
    let mimeType;
    let filePath;
    if (process.env.ENV !== "production") {
      filePath = path.join(BASE_DIRECTORY, target, source);
      if (!fs.existsSync(filePath)) {
        res.statusCode(500);
        return res.send("File not fund");
      }
      mimeType = mime.getType(path.parse(filePath).ext);
    } else {
      filePath = source;
      mimeType = mime.getType(path.parse(source).ext);
    }

    const stat = fs.statSync(filePath);
    const fileSize = stat.size;
    const range = req.headers.range;

    if (typeof range === "undefined") {
      const head = {
        "Content-Length": fileSize,
        "Content-Type": mimeType,
      };
      res.writeHead(200, head);
      return fs.createReadStream(filePath).pipe(res);
    }

    const parts = range.replace(/bytes=/, "").split("-");
    const start = parseInt(parts[0], 10);
    const end = parts[1] ? parseInt(parts[1], 10) : fileSize - 1;

    if (start >= fileSize) {
      res
        .status(416)
        .send(`Requested range not satisfiable ${start} >= ${fileSize}`);
      return;
    }

    const chunksize = end - start + 1;
    const file = fs.createReadStream(filePath, { start, end });
    const head = {
      "Content-Range": `bytes ${start}-${end}/${fileSize}`,
      "Accept-Ranges": "bytes",
      "Content-Length": chunksize,
      "Content-Type": mimeType,
    };

    res.writeHead(206, head);
    return file.pipe(res);
  } catch (error) {
    let message;
    switch (error.code) {
      case "ENOENT":
        message = "The source file does not exist!";
        break;
      default:
        message = "Internal server error!";
        break;
    }
    return res.status(500).send(message);
  }
});

app.listen(PORT, function () {
  console.log('Listening on port ' + PORT);
});
