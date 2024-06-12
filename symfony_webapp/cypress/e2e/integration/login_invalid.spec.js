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
      
      // login invalid
      cy.get('input[name="_username"]').type('newuser@example');
      cy.get('input[name="_password"]').type('123');
      cy.get('button[type="submit"]').click();
    });
  });
  