import {describe, it, expect} from 'vitest'
import { mount } from '@vue/test-utils'
import Daycare from '../../resources/js/Pages/Appointments/Daycare.vue'
import NavLink from '@/Components/NavLink.vue'

describe('Daycare', () => {
    // Mock the child component NavLink
    const mockNavLink = {
        template: '<div></div>',
        setup() {
            return {}
        },
    }

    it('renders NavLink component', async () => {
        const wrapper = mount(Daycare, {
            global: {
                components: {
                    NavLink: mockNavLink,
                },
            },
        })

        expect(wrapper.findComponent(NavLink).exists()).toBe(true)
    })

    it('renders correct table headers', async () => {
        const wrapper = mount(Daycare, {
            props: {
                appointments: [],
            },
        })

        const headers = wrapper.findAll('thead td')

        expect(headers[0].text()).toBe('Dog')
        expect(headers[1].text()).toBe('Visit Type')
        expect(headers[2].text()).toBe('Check In')
        expect(headers[3].text()).toBe('Check Out')
        expect(headers[4].text()).toBe('Paid')
        expect(headers[5].text()).toBe('Cancel Appointment')
    })

    it('renders appointment rows', async () => {
        const appointments = [
            {
                dog: { name: 'Rex' },
                visit_type: 'Regular',
                check_in: '2023-07-17',
                check_out: '2023-07-17',
            },
        ]

        const wrapper = mount(Daycare, {
            props: {
                appointments: appointments,
            },
        })

        const rows = wrapper.findAll('tbody tr')

        expect(rows.length).toBe(appointments.length)
        appointments.forEach((appointment, index) => {
            const cells = rows[index].findAll('td')
            expect(cells[0].text()).toBe(appointment.dog.name)
            expect(cells[1].text()).toBe(appointment.visit_type)
            expect(cells[2].text()).toBe(appointment.check_in)
            expect(cells[3].text()).toBe(appointment.check_out)
        })
    })
})
