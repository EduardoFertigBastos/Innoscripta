import styled from 'styled-components';

import TitleComponente from 'components/Typography/Title';

import { primaryColor, textColor } from '../../styles/variables';

export const Title = styled(TitleComponente)`
  margin-bottom: 25px !important;
`;

export const PageSignUp = styled.div` 
  width: 100%;
  max-width: 1100px;

  margin: 0 auto;
  
  header {
    margin-top: 24px;
  
    display: flex;
    justify-content: space-evenly;
    align-items: center;

    img {
      max-width: 450px;
    }
    
    @media screen and (max-width: 600px) {
      img {
        width: 70%;
      }
    }

    a {
      color: ${primaryColor};
      font-weight: bold;
      text-decoration: none;
    
      display: flex;
      align-items: center;

      
      @media screen and (max-width: 1200px) {
        margin-right: 20px;
      }

      @media screen and (max-width: 600px) {
        margin-right: 10px;
      }

      svg {
        margin-right: 16px;
        color: ${primaryColor};

        @media screen and (max-width: 600px) {
          font-size: 16px;
        }
      }
    }
    
  }

  form {
    margin: 40px auto;
    padding: 64px;
    max-width: 730px;
    background: #FFF;
    border-radius: 8px;

    display: flex;
    flex-direction: column;
    
    h1 {
      font-size: 36px;
    }

    
    button {
      width: 260px;
      align-self: flex-end;
      margin-top: 40px;
      transition: background-color 0.2s;
      cursor: pointer;
    }
    
  }
`;
  