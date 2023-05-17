/**********************************************************************************************************************
 *                                                                                                                    *
 * Project : dashboard                                                                                                *
 * File : Page.js                                                                                                     *
 *                                                                                                                    *
 * @author: Christian Denat                                                                                           *
 * @email: contact@noleam.fr                                                                                          *
 *                                                                                                                    *
 * Last updated on : 17/05/2023  09:19                                                                                *
 *                                                                                                                    *
 * Copyright (c) 2023 - noleam.fr                                                                                     *
 *                                                                                                                    *
 **********************************************************************************************************************/
import {Animation} from "Animation";
import {dsb} from "dsb";

export class Page {

    #template = null
    #page = null

    constructor(page, template) {
        this.#page = page
        this.#template = template
        dsb.instance.current_page

        //import sheet from './style.css' assert { type: 'css' };
        //document.adoptedStyleSheets = [sheet];
    }

    /**
     * Encapsulate dsb importWebComponents
     *
     * @param components
     */
    importWebComponents = (...components) => {
        dsb.utils.importWebComponents(components)
    }

    /**
     * template getter
     *
     * @return {Block|null}
     */
    get template() {
        return this.#template
    }

    /**
     * page getter
     *
     * @return {string|null}
     */
    get page() {
        return this.#page
    }

    /**
     * Those methods could be declared in the Controller Page Class
     * They are automatically called when we import the class and instantiate the controller
     *
     * Ordering :
     *      - import JS Page Controller          // in Dashboard class
     *      - call globalPageInitialisation      // call in Dashboard class
     *      - call attachEvents                  // call in Dashboard class
     *      - load Page                          // in Dashboard class
     *
     *      - call pageInitialisation            // call in Block

     * This is a  static method used to make some global initialisation

     static globalPageInitialisation  = ()=> {}

     * This method initialise page data

     pageInitialisation = () => {}

     * This is a method used to attach events before we load the page

     attachEvents  = ()=> {}

     *
     *
     */


    loaded() {
        Animation.loaded('#content#')
    }

}