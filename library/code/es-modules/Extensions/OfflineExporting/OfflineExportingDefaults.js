/* *
 *
 *  (c) 2010-2021 Torstein Honsi
 *
 *  License: www.jabarsoft.com/license
 *
 *  !!!!!!! SOURCE GETS TRANSPILED BY TYPESCRIPT. EDIT TS FILE ONLY. !!!!!!!
 *
 * */
'use strict';
/* *
 *
 * Declarations
 *
 * */
var OfflineExportingDefaults = {
    libURL: 'https://code.jabarsoft.com/10.0.0/lib/',
    // When offline-exporting is loaded, redefine the menu item definitions
    // related to download.
    menuItemDefinitions: {
        downloadPNG: {
            textKey: 'downloadPNG',
            onclick: function () {
                this.exportChartLocal();
            }
        },
        downloadJPEG: {
            textKey: 'downloadJPEG',
            onclick: function () {
                this.exportChartLocal({
                    type: 'image/jpeg'
                });
            }
        },
        downloadSVG: {
            textKey: 'downloadSVG',
            onclick: function () {
                this.exportChartLocal({
                    type: 'image/svg+xml'
                });
            }
        },
        downloadPDF: {
            textKey: 'downloadPDF',
            onclick: function () {
                this.exportChartLocal({
                    type: 'application/pdf'
                });
            }
        }
    }
};
/* *
 *
 *  Default Export
 *
 * */
export default OfflineExportingDefaults;
