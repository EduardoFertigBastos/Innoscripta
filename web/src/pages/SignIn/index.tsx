import React, { useCallback } from 'react';

import { Button }                                from '@mui/material';
import { Form }                                  from '@unform/web';
import { FiLock, FiMail }                        from 'react-icons/fi';
import { useNavigate }                           from 'react-router-dom';
import { Link }                                  from 'react-router-dom';

import Input from 'components/Form/Input';
import SubHead from 'components/Typography/SubHead';
import Title from 'components/Typography/Title';

import { useAuth } from 'hooks/auth';
import { useForm } from 'hooks/form/useForm';
import { useSettings } from 'hooks/settings';
import Toast from 'hooks/toast/Toast';

import logo from '../../assets/logo.svg';

import { AnimationContainer, Background, Container, Content } from './styles';
import { schema } from './validation/schema';

interface SignInFormData {
  email: string;
  password: string;
}

const SignIn: React.FC = () => {
  const navigate = useNavigate();
  const { signIn } = useAuth();
  const { getSettingsBackend } = useSettings();
  
  const form = useForm({ schema });	

  const handleSubmit = useCallback(
    async (data: SignInFormData) => {
      
      await form.validation(data);

      const toast = new Toast().loading();

      try {
        await signIn({ ...data });
        await getSettingsBackend();
        
        navigate('/dashboard');
        
        toast.dismiss();
      } catch (error) {
        
        toast.error('There was an error logging in, check your credentials.')                
      }
    },
    [navigate, signIn],
  );

  return (
    <Container>
      <Content>
    
        <AnimationContainer>
          <img src={logo} alt="Innoscripta" />

          <Form ref={form.ref} onSubmit={handleSubmit}>

            <Title variant="h4">
              Welcome
            </Title>
            <SubHead mb={3}>
              Sign up on the internal platform
            </SubHead>

            <Input type="text" 
              name="email" 
              icon={FiMail} 
              label="Email" 
              placeholder='abc@gmail.com' 
              mb={1} 
            />
            
            <Input type="password" 
              name="password"
              icon={FiLock}
              label="Password" 
              mb="1" 
            />

            <Button fullWidth size="large" sx={{ mt: 3 }} variant="contained" type='submit' color='primary' >
              Enter
            </Button>
            
            <Button
              fullWidth
              size="large"
              sx={{ mt: 3 }}
              color="primary"
              component={Link}
              to="/sign-up"
            >
              Create account
            </Button>
            
          </Form>
        </AnimationContainer>
      </Content>
      <Background />
    </Container>
  );
};

export default SignIn;
