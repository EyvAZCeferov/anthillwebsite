<script>
    function crSeo(nameinput, descinput, metatitleinput, metadescinput, metakeywordsinput) {
        var nameval = $("input[name='" + nameinput + "']").val();
        console.log(editors);
        if(editors!=null && editors.length>0){
            var descval =editors[descinput].getData();
            $("#" + metadescinput + "").val(createSeoDesc(nameval, descval));
        }
        $("#" + metatitleinput + "").val(toTitleCase(nameval));
        $("#" + metadescinput + "").val(createDescTitle(nameval, descval));
        $("#" + metakeywordsinput + "").val(createTag(nameval, descval));
    }

    function toTitleCase(str) {
        var strs = str.trim();
        return strs.replace(/(?:^|\s)\w/g, function(match) {
            return match.toUpperCase();
        });
    }

    function createSeoDesc(desc) {
        var descr = desc.trim();
        console.log(descr);
        descr = descr.replace(/<style[^>]*>.*<\/style>/gm, '')
            // Remove script tags and content
            .replace(/<script[^>]*>.*<\/script>/gm, '')
            // Remove all opening, closing and orphan HTML tags
            .replace(/<[^>]+>/gm, '')
            // Remove leading spaces and repeated CR/LF
            .replace(/([\r\n]+ +)+/gm, '').replace(/(<([^>]+)>)/gi, "");
        return descr.substring(0, 200);
    }

    function createDescTitle(name, desc) {
        if (name != null) {
            var seoname = toTitleCase(name);
            if(desc!=null && desc.length>0)
            {
                var seodesc = createSeoDesc(desc);
            }else{
                var seodesc="";
            }
            return seoname + " - " + seodesc;
        } else {
            alert("Ad boş qala bilməz!");
        }
    }

    function createTag(name, desc) {
        var data = []
        var names = name.trim().split(" ");
        for (var i = 0; i < names.length; i++) {
            data.push(names[i].toLowerCase());
        }
        if(desc!=null && desc.length>0){
            var descs = desc.trim().substring(0, 300).split(" ");
            for (var i = 0; i < descs.length; i++) {
                data.push(",");
                data.push(descs[i].toLowerCase().replace(/<style[^>]*>.*<\/style>/gm, '')
                    // Remove script tags and content
                    .replace(/<script[^>]*>.*<\/script>/gm, '')
                    // Remove all opening, closing and orphan HTML tags
                    .replace(/<[^>]+>/gm, '')
                    // Remove leading spaces and repeated CR/LF
                    .replace(/([\r\n]+ +)+/gm, '').replace(/(<([^>]+)>)/gi, "").replace("<p>", "").replace("</p>", "")
                    .replace("<span>", "").replace(
                        "</span>", "").replace("<h1>", "").replace("</h1>", "").replace("<h2>", "").replace("</h2>",
                        "").replace(",,,", ",").replace(",,", ',').trim());
            }
        }

        var replacing = data.toString().replace(",,", '');
        replacing = replacing.replace(",,,", ',');

        return replacing;
    }
</script>
