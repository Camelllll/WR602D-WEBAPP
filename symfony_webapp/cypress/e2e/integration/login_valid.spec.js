describe('Connexion valide', () => {
    beforeEach(() => {
      cy.on('uncaught:exception', (err, runnable) => {
        if (err.message.includes('Cannot set properties of null (setting \'onclick\')')) {
          return false;
        }
        return true;
      });
    });
  
    it('devrait se connecter avec des informations valides', () => {
      cy.visit('https://127.0.0.1:8000/login');
      
      // login
      cy.get('input[name="_username"]').type('newuser@example.com');
      cy.get('input[name="_password"]').type('password123');
      cy.get('button[type="submit"]').click();
    });
  });
  