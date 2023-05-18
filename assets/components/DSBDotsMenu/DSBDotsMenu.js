/**********************************************************************************************************************
 *                                                                                                                    *
 * Project : dashboard                                                                                                *
 * File : DSBDotsMenu.js                                                                                              *
 *                                                                                                                    *
 * @author: Christian Denat                                                                                           *
 * @email: contact@noleam.fr                                                                                          *
 *                                                                                                                    *
 * Last updated on : 17/05/2023  15:53                                                                                *
 *                                                                                                                    *
 * Copyright (c) 2023 - noleam.fr                                                                                     *
 *                                                                                                                    *
 **********************************************************************************************************************/

// web component

export class DSBDotsMenu extends HTMLElement {

    icon = 'fa-regular fa-ellipsis-vertical'
    direction = 'start'
    list = ''
    DIVIDER = 'divider'

    constructor() {
        super();

        // we do not use shadow root as it does not work with bootstrap

    }


    // component attributes
    static get observedAttributes() {
        return ['name', 'id', 'class', 'icon']
    }

    divider = () => {
        return '<li><hr class="dropdown-divider"></li>'
    }

    // attribute change
    attributeChangedCallback(property, oldValue, newValue) {

        if (oldValue === newValue) return;
        this[property] = newValue;

    }

    // connect component
    connectedCallback() {

        const container = this.querySelector('ul')
        this.querySelectorAll('dsb-dots-menu-item').forEach((element) => {
            const type = element.getAttribute('modal')
            let list = (type === this.DIVIDER) ? this.divider() : ''

            if (type !== this.DIVIDER) {
                let [context, action] = element.getAttribute('action').split('/')
                if (action === undefined) {
                    action = context
                    context = undefined
                }

                if (action === this.DIVIDER) {
                    list = this.divider()
                } else {

                    const modal = element.getAttribute('modal')
                    const icon = element.getAttribute('icon')
                    const text = element.getAttribute('text')

                    const dataAction = `data-action="${action}"`
                    const dataContext = (context !== null) ? ` data-context="${context}"` : ''
                    const dataModal = (modal !== null) ? ` data-bs-toggle="modal" data-bs-target="${modal}"` : ''
                    list = `<li><a href="#" class="dropdown-item" ${dataAction}${dataContext}${dataModal}><i class="${icon}"></i><span>${text}</span></a></li>\ `
                }
            }
            this.list += list

        })

        const template = `
<style>@import "/dashboard/assets/components/DSBDotsMenu/style.css"</style>
    <div class="drop${this.direction}">
        <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="${this.icon}"></i>
        </a>
        <ul class="dropdown-menu">
            ${this.list}
        </ul>
    </div>
  `
        this.innerHTML = template


        if (this.hasAttribute('id')) {
            this.setAttribute('id', this.id)
        }

    }

}

// register component
customElements.define('dsb-dots-menu', DSBDotsMenu);