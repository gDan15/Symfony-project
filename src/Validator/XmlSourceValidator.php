<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class XmlSourceValidator extends ConstraintValidator
{
  public function validate($value, Constraint $constraint)
  {
      $xsdSchema =
      "<xs:schema xmlns:xs=\"http://www.w3.org/2001/XMLSchema\" elementFormDefault=\"qualified\">
      <xs:element name=\"root\">
        <xs:complexType>
          <xs:sequence>
            <xs:element name=\"tag\"/>
          </xs:sequence>
        </xs:complexType>
      </xs:element>
      ";
      /* @var $constraint App\Validator\Xml */
      $doc = new \DOMDocument();
      $doc->loadXML($value);
      if(!$doc->schemaValidateSource($this->xsdSchema)){
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
      }
  }
}
?>
