/**********************************************************************************************************************
 *                                                                                                                    *
 * Project : dashboard                                                                                                *
 * File : DashboardExportUtils.js                                                                                     *
 *                                                                                                                    *
 * @author: Christian Denat                                                                                           *
 * @email: contact@noleam.fr                                                                                          *
 *                                                                                                                    *
 * Last updated on : 02/07/2023  10:08                                                                                *
 *                                                                                                                    *
 * Copyright (c) 2023 - noleam.fr                                                                                     *
 *                                                                                                                    *
 **********************************************************************************************************************/

import {DateTime} from 'luxon'

export class DashboardExportUtils {

    static fromHTMLToPDF = async (element, file) => {


        if (typeof element === 'string') {
            element = document.querySelector(element)
        }

        element.classList.toggle('snapshot-in-progress')

        await window.html2canvas(element, {
            dpi: 600
        }).then((canvas) => {
            element.classList.toggle('snapshot-in-progress')


            const orientation = canvas.width >= canvas.height ? 'l' : 'p'
            const imgData = canvas.toDataURL('image/png')
            const doc = new window.jspdf.jsPDF({
                orientation,
                unit: 'px',
                format: 'a4'
            })

            const ratio = canvas.height / canvas.width
            const margin = 20 //px
            let position = margin
            const fileName = `${file}.pdf`

            let componentWidth = Math.min(canvas.width, doc.internal.pageSize.width)
            let componentHeight = componentWidth * ratio
            if (orientation === 'p') {
                componentHeight = Math.min(canvas.height, doc.internal.pageSize.height)
                componentWidth = componentHeight / ratio
            }
            doc.internal.pageSize.width = componentWidth + 2 * margin
            doc.internal.pageSize.height = componentHeight + 2 * margin


            doc.addImage(imgData, 'PNG', margin, position, componentWidth, componentHeight)
            doc.setFontSize(10)
            doc.text(fileName, margin, position - margin / 2)
            doc.text(`Created on ${DateTime.now().toLocaleString(DateTime.DATETIME_FULL)}`,
                margin, doc.internal.pageSize.height - margin / 2)
            doc.save(fileName)
        })
    }
    static fromHTMLToPNG = async (element, file) => {
        if (typeof element === 'string') {
            element = document.querySelector(element)
        }
        element.classList.toggle('snapshot-in-progress')
        await window.html2canvas(element, {
            dpi: 600
        }).then((canvas) => {
            element.classList.toggle('snapshot-in-progress')
            const orientation = canvas.width >= canvas.height ? 'l' : 'p'
            canvas.toBlob((blob) => DashboardExportUtils.exportToFile(blob, `${file}.png`))
        })
    }
    /**
     * Copy a string to the clipboard
     *
     * @param text
     *
     * @since 1.0
     *
     */
    static toClipboard = async (text) => {
        let result = true
        if (!navigator.clipboard) {
            let c = document.createElement('textarea')
            c.value = text
            c.style.maxWidth = '0px'
            c.style.maxHeight = '0px'
            c.style.position = 'fixed'  // Prevent scrolling to bottom of page in Microsoft Edge.
            document.body.appendChild(c)
            c.focus()
            c.select()
            try {
                document.execCommand('copy')
            } catch (e) {
                result = false
            } finally {
                document.body.removeChild(c)
            }
        } else {
            try {
                await navigator.clipboard.writeText(text)
            } catch (e) {
                result = false
            }
        }
        return result
    }
    static copyCanvasToClipboard = (canvas) => {
        canvas.toBlob(function (blob) {
            const item = new ClipboardItem({'image/svg': blob})
            navigator.clipboard.write([item])
        })
    }
    /**
     * Export content to a file
     *
     * @param content
     * @param file
     */

    static exportToFile = (content = '', file = 'sample.txt') => {
        const link = document.createElement('a')
        const blob = new Blob([content], {type: 'text/plain'})
        link.href = URL.createObjectURL(blob)
        link.download = file
        link.click()
        URL.revokeObjectURL(link.href)
    }


}