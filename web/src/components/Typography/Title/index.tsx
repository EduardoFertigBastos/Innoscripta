import React from 'react';

import { Typography, TypographyProps } from '@mui/material';

interface TitleProps extends TypographyProps {

}

const Title: React.FC<TitleProps> = ({ 
  children, 
  variant = 'h1',
  ...rest 
}) => (
  <Typography 
    variant={variant}
    {...rest}
  >
    { children }
  </Typography>
)


export default Title;
