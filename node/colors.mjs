
import Vibrant from 'node-vibrant'
import rgbHex from 'rgb-hex';
import fs from 'fs';

/**
 * Pick up palette from image
 * @param {string} img_path
 */
const pickPalette = async (img_path) => {
    let v = new Vibrant(img_path)
    return await v.getPalette().then((palettes) => {
        return Object.getOwnPropertyNames(palettes).map((palette) => {
            return {name: palette, value: rgbToHex(palettes[palette]._rgb)}
        })
    })
}

/**
 * rgb to hex
 * @param {string} rgb_arr
 */
const rgbToHex = (rgb_arr) => {
    const [r, g, b] = rgb_arr;
    return rgbHex(r, g, b);
}

const main = async () => {
    const [node, js, ...args] = process.argv
    if(args.length > 0) {
        const result = await pickPalette(args[0])
        fs.writeFile(args[0] + ".json", JSON.stringify(result), (err) => {
            if (err) throw err;
        })
    } else {
        console.log('to use `npm run palette <IMAGE_PATH>`')
    }
}

main()
