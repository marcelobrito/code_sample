describe('Login', () => {
	beforeEach(() => {
        cy.visit('/')
        cy.server()
    })
    
    it('it should redirect to login', () => {
        cy.location().should((loc) => {
            expect(loc.pathname).to.eq('/login')
        });
    })

	it('it should attempt to submit login form without inform fields', () => {
		cy.log(Cypress.env('minhaVariavel'))
		cy.route({
			method: 'POST',
			url: '/api/v1/login',
			onResponse: () => expect('It should not be called').to.be.false
		})
		cy.get('.btn-primary').click()
		cy.get('.text-danger').contains('Please fill out the email field')
		cy.get('.text-danger').contains('Please fill out the password field')

	})

	it('it should attempt to inform invalid email', () => {
		cy.get('#email').then(($input) => {
			expect($input[0].validationMessage).to.be.empty
		})
		cy.get('#email').type('invalid_email')
		cy.get('.btn-primary').click()
		cy.get('#email').then(($input) => {
			cy.log($input[0].validationMessage)
			expect($input[0].validationMessage).to.not.be.empty
		})
    })
    
    it('Password should have at least 6 characteres', () => {
        cy.get('#password').type('123')
        cy.get('.btn-primary').click()
        cy.get('.text-danger').contains('The password field should have at least 6 characters')
    })

	it('it should return invalid login credentials', () => {
		cy.route('POST','/api/v1/login').as('login')
		cy.get('#email').type('marcelo.nakash@gmail.com')
		cy.get('#password').type('random_password')
		cy.get('.btn-primary').click()
		cy.wait('@login')
		cy.get('.text-danger').contains('Invalid credentials')

	})

	it('it should login', () => {
		cy.route('POST','/api/v1/login').as('login')
		cy.get('#email').type('marcelo.nakash@gmail.com')
		cy.get('#password').type('123456')
		cy.get('.btn-primary').click()
		cy.wait('@login').then(() => {
			cy.location().should((loc) => {
                expect(loc.pathname).to.eq('/')
            }); 
        })
	})
})