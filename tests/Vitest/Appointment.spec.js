import {describe, it, expect} from 'vitest'
import {mount} from '@vue/test-utils'
import Appointment from '../../resources/js/Pages/Appointments/Appointment.vue'

describe('Appointment', () => {
    let appointment = {
        check_in: '2023-07-17',
        check_out: '2023-07-18',
        dog: {name: 'Rex'},
        visit_type: 'full-day',
        paid: false,
    }

    it('renders appointment details', () => {

        const wrapper = mount(Appointment, {
            props: {
                appointment: appointment,
                visitTypes: ['half-day', 'full-day']
            }
        })

        const cells = wrapper.findAll('td')
        console.log(appointment);

        expect(cells[0].text()).toBe(appointment.dog.name)
        expect(cells[1].text()).toBe(appointment.check_in)
        expect(cells[2].text()).toBe(appointment.check_out)
    })

    it('renders checkbox correctly', () => {
        const wrapper = mount(Appointment, {
            props: {
                appointment: appointment,
                visitTypes: ['half-day', 'full-day']
            }
        })

        const checkbox = wrapper.find('input[type="checkbox"]')

        expect(checkbox.element.checked).toBe(false)
        expect(checkbox.classes()).toContain('checkbox')
        expect(checkbox.classes()).toContain('checkbox-xs')
    })

    it('Defaults to select one if visit_type is null', () => {
        appointment.visit_type = null
        const wrapper = mount(Appointment, {
            props: {
                appointment: appointment,
                visitTypes: ['full-day', 'half-day']
            }
        });

        const selectList = wrapper.find('select[id="visitType"]');
        expect(selectList.element.value).toBe('Select One')
    })

    it('Displays visit_type if it is not null', () => {
        appointment.visit_type = 'full-day'
        const wrapper = mount(Appointment, {
            props: {
                appointment: appointment,
                visitTypes: ['full-day', 'half-day']
            }
        });

        const selectList = wrapper.find('select[id="visitType"]');
        expect(selectList.element.value).toBe('full-day')
    })
})
