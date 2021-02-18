import XLSX from "xlsx";

export default {
    convertTimeToUnit(value, before, after){
        switch(before){
            case 'hour': 
                switch(after){
                    case 'minute': 
                        value = (parseFloat(value) * 60).toFixed(2);
                        break;
                    case 'second':
                        value = (parseFloat(value) * 60 * 60).toFixed(2);
                        break;
                    default:
                        value = value;    
                }
                break;
            case 'minute':
                switch(after){
                    case 'hour': 
                        value = (parseFloat(value)/60).toFixed(2);
                        break;
                    case 'second':
                        value = (parseFloat(value) * 60).toFixed(2);
                        break;
                    default:
                        value = value;    
                }
                break;
            case 'second':
                switch(after){
                    case 'hour': 
                        value = (parseFloat(value)/60).toFixed(2);
                        break;
                    case 'second':
                        value = (parseFloat(value) / (60 * 60 )).toFixed(2);
                        break;
                    default:
                        value = value;    
                }
                break;    
        }

        return value;
    },
    get_header_row(sheet) {
        var headers = [], range = XLSX.utils.decode_range(sheet['!ref']);
        var C, R = range.s.r; /* start in the first row */
        for(C = range.s.c; C <= range.e.c; ++C) { /* walk every column in the range */
            var cell = sheet[XLSX.utils.encode_cell({c:C, r:R})] /* find the cell in the first row */
            var hdr = "UNKNOWN " + C; // <-- replace with your desired default 
            if(cell && cell.t) hdr = XLSX.utils.format_cell(cell);
            headers.push(hdr);
        }
        return headers;
    },
    fixdata(data) {
        var o = "", l = 0, w = 10240;
        for(; l<data.byteLength/w; ++l) o+=String.fromCharCode.apply(null,new Uint8Array(data.slice(l*w,l*w+w)));
        o+=String.fromCharCode.apply(null, new Uint8Array(data.slice(l*w)));
        return o;
    },
    setDefaultValue($value){
        return $value == undefined ? '' : $value;
    }
};