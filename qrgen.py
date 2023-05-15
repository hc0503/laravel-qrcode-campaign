#!/usr/bin/env python
import qrcode
import argparse
import sys
from PIL import ImageColor
from PIL import Image
import secrets
import logging
import warnings
warnings.filterwarnings("ignore", category=DeprecationWarning)

parser = argparse.ArgumentParser()
parser.add_argument("text", help="Text to insert in qrcode")
parser.add_argument("--logo", help="Path of the Logo")
parser.add_argument("--fg", help="HEX of Fill Color")
parser.add_argument("--bg", help="HEX of Background Color")
parser.add_argument("--output", help="Output Path of PNG")
parser.add_argument("--debug", help="Enable Debug", action='store_true')
args = parser.parse_args()

if args.debug:
    logging.basicConfig(filename='/app/storage/logs/qr.log', level=logging.DEBUG)
    logging.debug("PARSED ARGS")
    
if args.fg is None:
    args.fg = "#000000"

if args.bg is None:
    args.bg = "#FFFFFF"

args.fg = args.fg.replace("\\", "")
args.bg = args.bg.replace("\\", "")

if args.output is None:
    args.output = f"./{secrets.token_hex(15)}.png"

if args.debug:
    logging.debug("ARGS SETTED")
try:
    qr = qrcode.QRCode(error_correction=qrcode.constants.ERROR_CORRECT_H, version=None)
    qr.add_data(args.text)
    qr.make(fit=True)
    img = qr.make_image(fill_color=ImageColor.getcolor(args.fg, "RGB"), back_color=ImageColor.getcolor(args.bg, "RGB"))
    if args.logo is not None:
        logo = Image.open(args.logo)
        basewidth = 100
        wpercent = (basewidth/float(logo.size[0]))
        hsize = int((float(logo.size[1])*float(wpercent)))
        logo = logo.resize((basewidth, hsize), Image.ANTIALIAS)
        pos = ((img.size[0] - logo.size[0]) //2, (img.size[1] - logo.size[1]) //2)
        img.paste(logo, pos)
    img.save(args.output)
    if args.debug:
        logging.debug("ALL OK")
except Exception as e:
    if args.debug:
        logging.debug(f"EXCEPTION {e} OCCURRED")
        exit(-1)
print(args.output)
