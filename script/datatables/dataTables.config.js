$.extend(true, $.fn.dataTable.defaults, {
    "scrollX": true,
    "serverSide": true,
    "processing": true,
    "stateSave": false,
    "paging": true,
    "info": true,
    "searchHighlight": true,
    "pageLength": 25,
    "lengthMenu": [[25, 50, 100, 200],[25, 50, 100, 200]],
    "dom":
        "<'card-body pb-0'<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-8 mt-2 mt-md-0'f>>>"+
        "<'row'<'col-sm-12'tr>>"+
        "<'card-body pt-0'<'row mt-md-2'<'col-9 col-md-5'i><'col-3 col-md-7'p>>>",
    "language": {
        "emptyTable": "ไม่มีข้อมูลในตาราง",
        "info": "_START_ - _END_ จาก _TOTAL_ รายการ",
        "infoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
        "infoThousands": ",",
        "lengthMenu": "_MENU_ รายการ/หน้า",
        "loadingRecords": "กำลังโหลดข้อมูล...",
        "processing": "กำลังดำเนินการ...",
        "zeroRecords": "ไม่พบข้อมูล",
        "paginate": {
            "first": "&laquo;",
            "previous": "&lsaquo;",
            "next": "&rsaquo;",
            "last": "&raquo;"
        },
        "aria": {
            "sortAscending": ": เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก",
            "sortDescending": ": เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย"
        },
        "autoFill": {
            "cancel": "ยกเลิก",
            "fill": "กรอกทุกช่องด้วย",
            "fillHorizontal": "กรอกตามแนวนอน",
            "fillVertical": "กรอกตามแนวตั้ง"
        },
        "buttons": {
            "collection": "ชุดข้อมูล",
            "colvis": "การมองเห็นคอลัมน์",
            "colvisRestore": "เรียกคืนการมองเห็น",
            "copy": "คัดลอก",
            "copyKeys": "กดปุ่ม Ctrl หรือ Command + C เพื่อคัดลอกข้อมูลบนตารางไปยัง Clipboard ที่เครื่องของคุณ",
            "copySuccess": {
                "_": "คัดลอกช้อมูลแล้ว จำนวน %ds แถว",
                "1": "คัดลอกข้อมูลแล้ว จำนวน 1 แถว"
            },
            "copyTitle": "คัดลอกไปยังคลิปบอร์ด",
            "csv": "CSV",
            "excel": "Excel",
            "pageLength": {
                "_": "แสดงข้อมูล %d แถว",
                "-1": "แสดงข้อมูลทั้งหมด"
            },
            "pdf": "PDF",
            "print": "สั่งพิมพ์"
        },
        "infoEmpty": "ไม่มีรายการ",
        "search": "ค้นหา :",
        "thousands": ",",
        "datetime": {
            "amPm": [
                "เที่ยงวัน",
                "เที่ยงคืน"
            ],
            "hours": "ชั่วโมง",
            "minutes": "นาที",
            "months": {
                "0": "มกราคม",
                "1": "กุมภาพันธ์",
                "10": "พฤศจิกายน",
                "11": "ธันวาคม",
                "2": "มีนาคม",
                "3": "เมษายน",
                "4": "พฤษภาคม",
                "5": "มิถุนายน",
                "6": "กรกฎาคม",
                "7": "สิงหาคม",
                "8": "กันยายน",
                "9": "ตุลาคม"
            },
            "next": "ถัดไป",
            "previous": "ก่อนกน้า",
            "seconds": "วินาที",
            "unknown": "ไม่ทราบ",
            "weekdays": [
                "วันอาทิตย์",
                "วันจันทร์",
                "วันอังคาร",
                "วันพุธ",
                "วันพฤหัส",
                "วันศุกร์",
                "วันเสาร์"
            ]
        },
        "decimal": "จุดทศนิยม",
        "editor": {
            "close": "ปิด",
            "create": {
                "button": "สร้าง",
                "submit": "สร้างข้อมูล",
                "title": "สร้างข้อมูลใหม่"
            },
            "edit": {
                "button": "แก้ไข",
                "submit": "บันทึก",
                "title": "แก้ไขข้อมูล"
            },
            "error": {
                "system": "เกิดข้อผิดพลาดของระบบ (&lt;a target=\"\\\" rel=\"nofollow\" href=\"\\\"&gt;ดูข้อมูลเพิ่มเติม)."
            },
            "remove": {
                "button": "ลบ",
                "submit": "ลบข้อมูล",
                "title": "ลบข้อมูล",
                "confirm": {
                    "_": "คุณแน่ใจที่จะลบข้อมูล %d รายการนี้ หรือไม่?",
                    "1": "คุณแน่ใจที่จะลบข้อมูลรายการนี้ หรือไม่?"
                }
            },
            "multi": {
                "restore": "ยกเลิกการแก้ไข"
            }
        },
        "searchBuilder": {
            "add": "เพิ่มเงื่อนไข",
            "clearAll": "ยกเลิกทั้งหมด",
            "condition": "เงื่อนไข",
            "data": "ข้อมูล",
            "deleteTitle": "ลบเงื่อนไขการกรอง"
        },
        "select": {
            "cells": {
                "1": "เลือก 1 cell",
                "_": "เลือก %d cells"
            },
            "columns": {
                "1": "เลือก 1 column",
                "_": "เลือก %d columns"
            }
        }
    }
});