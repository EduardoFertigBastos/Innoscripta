import React, { useCallback, useEffect } from 'react';

import SendIcon from '@mui/icons-material/Send';
import { Button } from '@mui/material';
import { Form as FormUnform } from '@unform/web';
import { FiArrowLeft, FiLock }                             from 'react-icons/fi';
import { MdOutlineAlternateEmail, MdOutlineDescription }   from 'react-icons/md';
import { Link, useNavigate }                  from 'react-router-dom';

import FormBuilder from 'components/Form/FormBuilder';
import IGridField        from 'components/Form/FormBuilder/interfaces/IGridField';

import { useAuth }      from 'hooks/auth';
import { useForm } from 'hooks/form/useForm';
import handleAxiosError from 'hooks/handleAxiosError';
import { useSettings } from 'hooks/settings';
import Toast          from 'hooks/toast/Toast';

import logo from '../../assets/logo.svg'
import api from '../../services/api';

import { PageSignUp, Title } from './styles';
import { schema } from './validation/schema';

interface SignUpData {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
}

const SignUp = () =>
{
    const form = useForm({ schema });
    const { user, signIn } = useAuth();
    const { getSettingsBackend } = useSettings();
    const navigate = useNavigate();

    const handleSubmit = useCallback(
        async (data: SignUpData) => {
            await form.validation(data);
            
            const toast = new Toast().loading();
            
            try {
                await api.post('/users', data);

                await signIn({ 
                    email: data.email,
                    password: data.password
                });

                await getSettingsBackend();
            
                navigate('/dashboard');

                toast.success('Congratulations! You are registered!', {
                    autoClose: 1000,
                });
            } catch (error: any) {
                const { message } = handleAxiosError(error);
                toast.error(`Ops... ${message}`);      
            }
        }, [form, getSettingsBackend, navigate, signIn],
    );

    const fieldsForm: IGridField[] = [
        {            
            type: "text", 
            name: "name", 
            icon: MdOutlineDescription, 
            label: "Name",
            placeholder: 'Berta' 
        },
        {            
            type: "email", 
            name: "email", 
            icon: MdOutlineAlternateEmail, 
            label: "Email",
            placeholder: 'berta@innoscripta.com' 
        },
        {
            type: "password", 
            name: "password",
            icon: FiLock,
            label: "Password", 
            placeholder: '********' ,
        }, 
        {
            type: "password",
            name: "password_confirmation",
            icon: FiLock,
            label: "Confirm your password", 
            placeholder: '********' 
        }
    ];
    
    return (
      <>
        <PageSignUp>
            
            <header>
                <img src={logo} alt="Innoscripta"/>
                <Link to="/">
                    <FiArrowLeft />
                    Back
                </Link>                
            </header>
        
            <FormUnform ref={form.ref} onSubmit={handleSubmit}>
                <Title>
                    Register User
                </Title>

                <FormBuilder fields={fieldsForm} />

                <Button fullWidth 
                    variant="contained" 
                    type='submit'
                    endIcon={<SendIcon />} 
                >
                    Register
                </Button>
            </FormUnform>
        </PageSignUp>
      </>
    )
}

export default SignUp;