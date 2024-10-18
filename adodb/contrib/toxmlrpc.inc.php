<?php
/**  Programa para el manejo de gestion documental, oficios, memorandus, circulares, acuerdos
*    Desarrollado y en otros Modificado por la SubSecretaría de Informática del Ecuador
*    Quipux    www.gestiondocumental.gov.ec
*------------------------------------------------------------------------------
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU Affero General Public License as
*    published by the Free Software Foundation, either version 3 of the
*    License, or (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU Affero General Public License for more details.
*
*    You should have received a copy of the GNU Affero General Public License
*    along with this program.  If not, see http://www.gnu.org/licenses. 
*------------------------------------------------------------------------------
**/

    /**
    * Helper functions to convert between ADODB recordset objects and XMLRPC values.
    * Uses John Lim's AdoDB and Edd Dumbill's phpxmlrpc libs
    * 
    * @author Daniele Baroncelli
    * @author Gaetano Giunta    
    * 
    * @todo some more error checking here and there
    * @todo document the xmlrpc-struct used to encode recordset info
    */

    /**
    * Include the main libraries
    */    
    require_once('xmlrpc.inc');
    require_once('adodb.inc.php');
            
    /**
    * Builds an xmlrpc struct value out of an AdoDB recordset
    */
    function rs2xmlrpcval(&$adodbrs) {

        $numfields = $adodbrs->FieldCount();
        $numrecords = $adodbrs->RecordCount();

        // build structure holding recordset information
        $fieldstruct = array();
        for ($i = 0; $i < $numfields; $i++) {
            $fld = $adodbrs->FetchField($i);
            $fieldarray = array();
            if (isset($fld->name))
                $fieldarray["name"] = new xmlrpcval ($fld->name);
            if (isset($fld->type))
                $fieldarray["type"] = new xmlrpcval ($fld->type);
            if (isset($fld->max_length))
                $fieldarray["max_length"] = new xmlrpcval ($fld->max_length, "int");
            if (isset($fld->not_null))
                $fieldarray["not_null"] = new xmlrpcval ($fld->not_null, "boolean");
            if (isset($fld->has_default))
                $fieldarray["has_default"] = new xmlrpcval ($fld->has_default, "boolean");
            if (isset($fld->default_value))
                $fieldarray["default_value"] = new xmlrpcval ($fld->default_value);
            $fieldstruct[$i] = new xmlrpcval ($fieldarray, "struct");
        }
        $fieldcount = new xmlrpcval ($numfields, "int");
        $recordcount = new xmlrpcval ($numrecords, "int");
        $sql = new xmlrpcval ($adodbrs->sql);
        $fieldinfo = new xmlrpcval ($fieldstruct, "array");

        $header = new xmlrpcval ( array(
                "fieldcount" => $fieldcount,
                "recordcount" => $recordcount,
                "sql" => $sql,
                "fieldinfo" => $fieldinfo
                ), "struct");

        // build structure containing recordset data
        $rows = array();
        while (!$adodbrs->EOF) {
            $columns = array();
            // This should work on all cases of fetch mode: assoc, num, both or default
            if ($adodbrs->fetchMode == 'ADODB_FETCH_BOTH' || count($adodbrs->fields) == 2 * $adodbrs->FieldCount())
                for ($i = 0; $i < $numfields; $i++)
                    if ($columns[$i] === null)
                        $columns[$i] = new xmlrpcval ('');
                    else
                        $columns[$i] = xmlrpc_encode ($adodbrs->fields[$i]);
            else
                foreach ($adodbrs->fields as $val)
                    if ($val === null)
                        $columns[$i] = new xmlrpcval ('');
                    else
                        $columns[] = xmlrpc_encode ($val);

            $rows[] = new xmlrpcval ($columns, "array");

            $adodbrs->MoveNext();
        }
        $body = new xmlrpcval ($rows, "array");

        // put it all together and build final xmlrpc struct
        $xmlrpcrs = new xmlrpcval ( array(
                "header" => $header,
                "body" => $body,
                ), "struct");

        return $xmlrpcrs;

    }

    /**
    * Returns an xmlrpc struct value as string out of an AdoDB recordset
    */    
    function rs2xmlrpcstring (&$adodbrs) {
        $xmlrpc = rs2xmlrpcval ($adodbrs);
        if ($xmlrpc)
          return $xmlrpc->serialize();
        else
          return null;
    }

    /**
    * Given a well-formed xmlrpc struct object returns an AdoDB object
    * 
    * @todo add some error checking on the input value
    */
    function xmlrpcval2rs (&$xmlrpcval) {

        $fields_array = array();
        $data_array = array();
 
        // rebuild column information  
        $header =& $xmlrpcval->structmem('header');
        
        $numfields = $header->structmem('fieldcount');
        $numfields = $numfields->scalarval();
        $numrecords = $header->structmem('recordcount');
        $numrecords = $numrecords->scalarval();
        $sqlstring = $header->structmem('sql');
        $sqlstring = $sqlstring->scalarval();
        
        $fieldinfo =& $header->structmem('fieldinfo');
        for ($i = 0; $i < $numfields; $i++) {
            $temp =& $fieldinfo->arraymem($i);
            $fld = new ADOFieldObject();
            while (list($key,$value) = $temp->structeach()) {
                if ($key == "name") $fld->name = $value->scalarval();
                if ($key == "type") $fld->type = $value->scalarval();
                if ($key == "max_length") $fld->max_length = $value->scalarval();
                if ($key == "not_null") $fld->not_null = $value->scalarval();
                if ($key == "has_default") $fld->has_default = $value->scalarval();
                if ($key == "default_value") $fld->default_value = $value->scalarval();
            } // while
            $fields_array[] = $fld;
        } // for

        // fetch recordset information into php array
        $body =& $xmlrpcval->structmem('body');
        for ($i = 0; $i < $numrecords; $i++) {
            $data_array[$i]= array();
            $xmlrpcrs_row =& $body->arraymem($i);
            for ($j = 0; $j < $numfields; $j++) {
                $temp =& $xmlrpcrs_row->arraymem($j);
                $data_array[$i][$j] = $temp->scalarval();
            } // for j
        } // for i

        // finally build in-memory recordset object and return it
        $rs = new ADORecordSet_array();
        $rs->InitArrayFields($data_array,$fields_array);
        return $rs;

    }

?>
