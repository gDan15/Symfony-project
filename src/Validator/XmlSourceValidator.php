<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class XmlSourceValidator extends ConstraintValidator
{
  //TODO : when can i define a root node in xml
  private $xsdSchema =
  "<xs:schema xmlns:xs=\"http://www.w3.org/2001/XMLSchema\" elementFormDefault=\"qualified\">
    <xs:element name=\"content\">
      <xs:complexType>
        <xs:sequence>
          <xs:element type=\"xs:string\" name=\"tag\"/>
        </xs:sequence>
      </xs:complexType>
    </xs:element>
  ";
  public function validate($value, Constraint $constraint)
  {
      /* @var $constraint App\XmlSource */
      $doc = new \DOMDocument();
      // TODO : tag doesn't stay in $value. Instead of having "<tag> Chicken </tag>" the value is "Chicken ". It is still there in the database.
      var_dump($value);
      $doc->loadXML($value, LIBXML_NOBLANKS);
      if(!$doc->schemaValidateSource($this->xsdSchema)){
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
      }
  }
}
?>
