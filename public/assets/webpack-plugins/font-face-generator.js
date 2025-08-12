var _ = require('underscore');
var path = require('path');
var fs = require('fs');
var grunt = require('grunt')


class FontFaceGenerator{
    constructor(options) {
        this.options = options;
        this.fontFiles = [];
        this.uniqFontFiles = [];
        this.contents = '';
    }
    apply(compiler) {

        fs.readdirSync(process.cwd() +'/'+this.options.fontDir, function (err,files){
            files.forEach(function (file) {
                if (file.indexOf('-webfont') !== -1){
                    var workingFile = path.resolve(file);
                    console.log(workingFile)
                    fs.rename(workingFile, workingFile.replace('-webfont', '', function (err) {
                        if (err) throw err;
                    }))
                }
            })
        });

        let self = this

        grunt.file.recurse(process.cwd()+'/'+this.options.fontDir, function (abspath, rootdir, subdir, filename) {
            if (filename.indexOf(self.options.removeFromFile) !== -1) {

                grunt.log.writeln('>>Renaming ' + filename);

                var workingFile = path.resolve(process.cwd() + '/' + self.options.fontDir + '/' + filename);

                fs.renameSync(workingFile, workingFile.replace('-webfont', ''), function(err) {
                    if (err) throw err;
                });
                filename = filename.replace(self.options.removeFromFile, '');
            }


            var processFile = filename.substring(0, filename.lastIndexOf('.'));

            self.fontFiles.push(processFile);

        })

        this.uniqFontFiles = _.uniq(this.fontFiles).filter(function (el) {
            if (el)
                return el;
        })

        this.uniqFontFiles.forEach(function (el) {

            _.templateSettings ={
                interpolate: /\{\{(.+?)\}\}/g
            }

                       var n = el.split('-');

            var weight = 'normal', fontStyle = 'normal', name = n[0];

            if (n[1] !== undefined) {
                var fontE = n[1], nameArr = fontE.split(/(?=[A-Z])/);

                if (nameArr.includes('Italic')) {
                    fontStyle = 'italic';
                }
                switch (true) {
                    case nameArr.includes('Black'):
                        weight = 900;
                        break;
                    case nameArr.includes('Semi') && nameArr.includes('Bold'):
                        weight = 600;
                        break;
                    case nameArr.includes('Extra') && nameArr.includes('Light'):
                        weight = 200;
                        break;
                    case nameArr.includes('Light'):
                        weight = 300;
                        break;
                    case nameArr.includes('Bold'):
                        weight = 'bold';
                        break;
                    case nameArr.includes('Thin'):
                        weight = 100;
                        break;
                    case nameArr.includes('Regular'):
                        weight = 'normal';
                        break;
                    case nameArr.includes('Medium'):
                        weight = 500;
                        break;
                }
            }

            var template = _.template(self.options.template);
            self.contents += template({font: name,fontFile: el, w: weight, s:fontStyle }) + grunt.util.linefeed

        })

        grunt.file.write(self.options.outputFile,self.contents)
    }

}

module.exports = FontFaceGenerator;
