describe('Connexion valide et génération de PDF', () => {
    beforeEach(() => {
      cy.on('uncaught:exception', (err, runnable) => {
        if (err.message.includes('Cannot set properties of null (setting \'onclick\')')) {
          return false;
        }
        return true;
      });
    });
  
    it('devrait se connecter avec des informations valides et générer un PDF', () => {
      cy.visit('https://127.0.0.1:8000/login');
      
      // login
      cy.get('input[name="_username"]').type('newuser@example.com');
      // Changer le mot de passe pour le rendre invalide
      cy.get('input[name="_password"]').type('123');
      cy.get('button[type="submit"]').click();
  
      // Changer de page
      cy.visit('https://127.0.0.1:8000/pdf/create');
  
      // Remplir le formulaire de génération de PDF
      cy.get('input[name="pdf[title]"]').type('Mon premier PDF');
      cy.get('input[name="pdf[url]"]').type('https://google.com');
      cy.get('button[type="submit"]').click();
    });
  });
  