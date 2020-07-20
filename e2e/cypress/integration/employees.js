describe('employees', () => {

    let employee = {
        name: 'marcelo',
        email: 'marcelo.nakash@gmail.com'
    }

    beforeEach(() => {
        localStorage.setItem('token','bWFyY2Vsby5uYWthc2hAZ21haWwuY29t')
        cy.server()
        cy.route('GET','/api/v1/employees').as('employees')
        cy.visit('/employees')
    })

    
    it('it should validate required fields for employee', () => {
        cy.get('.text-info').contains('Create Employee').click();
        cy.get('#employeesModal .btn-primary').click()

        cy.get('.text-danger').contains('Please fill out the name field')
        cy.get('.text-danger').contains('Please fill out the email field')
    })

    it('it should create a new employee', () => {
        
        cy.get('.text-info').contains('Create Employee').click();
        cy.get('#employeesModal').should('be.visible');

        cy.get('#name').type(employee.name)
        cy.get('#email').type(employee.email)
        
        cy.route('POST','/api/v1/employees').as('createEmployee')
        cy.get('#employeesModal .btn-primary').click()

        cy.wait('@createEmployee')
        cy.get('.list-group-item').contains(employee.name)
        cy.get('.list-group-item').contains(employee.email)
    })

    it('it should edit a employee', () => {
        cy.wait('@employees')

        cy.get('.list-group-item:first').find('.btn-primary').click()
        cy.get('#employeesModal').should('be.visible');

        employee = {
            name: 'marcelo 2',
            email: 'marcelo.nakash2@gmail.com'
        }

        cy.get('#email').clear()
        cy.get('#name').clear()

        cy.get('#name').type(employee.name)
        cy.get('#email').type(employee.email)
        
        cy.route('PUT','/api/v1/employees/**').as('editEmployee')
        cy.get('#employeesModal .btn-primary').click()

        cy.wait('@editEmployee')
        cy.get('.list-group-item').contains(employee.name)
        cy.get('.list-group-item').contains(employee.email)

    })

    it('it should delete employee', () => {
        cy.wait('@employees')

        cy.route('DELETE','/api/v1/employees/**').as('deleteEmployee')

        cy.get('.list-group-item').contains(employee.email).parent().find('.btn-danger').click()
        cy.wait('@deleteEmployee')

        cy.get('.list-group').contains(employee.name).should('not.exist')
        cy.get('.list-group').contains(employee.email).should('not.exist')
    })
})