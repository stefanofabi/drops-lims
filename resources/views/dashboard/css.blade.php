$primary-brand: #005fa4;
$text-outside: #4d4d4d;
$text-inside: #fff;
$transition-in: all 250ms ease-out;
$transition-out: all 250ms ease-in;

.container {
  width: 100%;
  height: 480px;
}

#learn-more {
  fill-opacity: 0;
  fill: #fff;
  stroke: #fff;
  stroke-width: 2;
  border-radius: 5px;
  stroke-linejoin: round;
  transition: $transition-out;
  cursor: pointer;

  &:hover {
    fill-opacity: 1;

    & ~ .learn-more-text {
      fill: $primary-brand;
    }
  }
}
.learn-more-text {
  font-family: 'Roboto';
  fill: #fff;
  pointer-events: none;
  font-size: 14px;
  transition: $transition-out;
}

.center {
  fill: $primary-brand;
}

.pointer {
  fill: #fff;
  stroke: #3b8fc0;
  stroke-width: 2;
}

.nav-copy {
  font-family: 'Roboto';
  fill: #fff;
  fill-opacity: 1;
  transition: $transition-out;
  
  &.changing {
    fill-opacity: 0;
  }
}
.service {
  cursor: pointer;
  
  text {
    font-size: 14px;
    font-family: 'Roboto';
    text-anchor: middle;
  }
 
  .icon-wrapper {
    transform-origin: 50% 50%;
    
    & , & > * {
       transition: $transition-out;
    }
  }
  circle {
    fill: $primary-brand;
    
    &.shadow {
      fill-opacity: 0;
      filter: url(#service-shadow);
    }
  }
  
  use {
    fill: #fff;
  }
  
  text {
    fill: $text-outside;
  }
  
  &.active, &:hover {
    
    .icon-wrapper {
      transform: scale(1.15) translateY(-5px);
      
      & , & > * {
        transition: $transition-in;
      }
      
      circle {
        &.shadow {
          fill-opacity: 0.4;
        }
      }
    }
    
    text {
      fill: $primary-brand;
      font-weight: bold;
    }
    
  }
}