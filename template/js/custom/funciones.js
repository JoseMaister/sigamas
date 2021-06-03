function paddy(num, padlen, padchar) {
    var pad_char = typeof padchar !== 'undefined' ? padchar : '0';
    var pad = new Array(1 + padlen).join(pad_char);
    return (pad + num).slice(-pad.length);
}

function detectURL(text) 
{
    var urlRegex = /(https?:\/\/[^\s]+)/g;
    return text.replace(urlRegex, function(url) 
    {
        return '<a target="_blank" style="text-decoration: underline;" href="' + url + '">' + url + '</a>';
    });
}

function File_image(archivo) {
    var ext = archivo.split('.');
    //ext = strtolower($ext[count($ext) - 1]);
    ext = (ext[ext.length - 1]).toLowerCase();

    switch (ext)
    {
        case "avi":
            return base_url + "template/images/files/" + "avi.png";
        case "css":
            return base_url + "template/images/files/" + "css.png";
        case "csv":
            return base_url + "template/images/files/" + "csv.png";
        case "dbf":
            return base_url + "template/images/files/" + "dbf.png";
        case "doc":
            return base_url + "template/images/files/" + "doc.png";
        case "docx":
            return base_url + "template/images/files/" + "doc.png";
        case "dwg":
            return base_url + "template/images/files/" + "dwg.png";
        case "exe":
            return base_url + "template/images/files/" + "exe.png";
        case "html":
            return base_url + "template/images/files/" + "html.png";
        case "iso":
            return base_url + "template/images/files/" + "iso.png";
        case "js":
            return base_url + "template/images/files/" + "js.png";
        case "jpg":
            return base_url + "template/images/files/" + "jpg.png";
        case "json":
            return base_url + "template/images/files/" + "json.png";
        case "mp3":
            return base_url + "template/images/files/" + "mp3.png";
        case "mp4":
            return base_url + "template/images/files/" + "mp4.png";
        case "pdf":
            return base_url + "template/images/files/" + "pdf.png";
        case "png":
            return base_url + "template/images/files/" + "png.png";
        case "ppt":
            return base_url + "template/images/files/" + "ppt.png";
        case "pptx":
            return base_url + "template/images/files/" + "ppt.png";
        case "ppsx":
            return base_url + "template/images/files/" + "ppt.png";
        case "psd":
            return base_url + "template/images/files/" + "psd.png";
        case "rtf":
            return base_url + "template/images/files/" + "rtf.png";
        case "search":
            return base_url + "template/images/files/" + "search.png";
        case "rar":
            return base_url + "template/images/files/" + "rar.png";
        case "svg":
            return base_url + "template/images/files/" + "svg.png";
        case "txt":
            return base_url + "template/images/files/" + "txt.png";
        case "xls":
            return base_url + "template/images/files/" + "xls.png";
        case "xlsx":
            return base_url + "template/images/files/" + "xls.png";
        case "xml":
            return base_url + "template/images/files/" + "xml.png";
        case "zip":
            return base_url + "template/images/files/" + "zip.png";
        default:
            return base_url + "template/images/files/" + "file.png";
    }
  }