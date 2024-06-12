describe('Création de compte valide', () => {
  beforeEach(() => {
    cy.on('uncaught:exception', (err, runnable) => {
      if (err.message.includes('Cannot set properties of null (setting \'onclick\')')) {
        return false;
      }
      return true;
    });
  });

  it('devrait créer un compte avec des informations valides', () => {
    cy.visit('https://127.0.0.1:8000/register');
    
    // Remplir le formulaire d'inscription
    cy.get('input[name="registration_form[email]"]').type('newuser4@example.com');
    cy.get('input[name="registration_form[plainPassword]"]').type('123');
    cy.get('input[name="registration_form[firstname]"]').type('John');
    cy.get('input[name="registration_form[lastname]"]').type('Doe');
    cy.get('input[name="registration_form[agreeTerms]"]').check();
    cy.get('button[type="submit"]').click();
  });
});
