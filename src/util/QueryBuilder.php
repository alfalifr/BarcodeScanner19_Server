<?php
    namespace ise\barscan\util;
use ise\barscan\util\debug\Debug;

    class QueryBuilder{
        static $whereCo= [
            "AND", "OR"
        ];
        static $operator= [
            "=", ">", ">=", "<", "<="
        ];
        static $charBahaya= [
            "'", '"'
        ];

        var $perintah= "SELECT";
        var $attrib= "*";
        var $table= "";
        var $where= "";


        /**
         * - Untuk format $where:
         *      id = $ AND pass = $
         *      - $ untuk menandai tempat $nilai
         *      - Beri spasi antar elemen attrib, operator, dan nilai
         * - Hanya melakukan cek pada $nilai yg bersifat dinamis
         */
        static function selectLengkap(string $attrib, string $table,
                            string $where, array $nilai): string {
            $where= str_replace("'", "", $where);
            $i= 0;
            foreach($nilai as $perNilai){
                $perNilai= str_replace("'", "", $perNilai);
                $perNilai= str_replace('"', "", $perNilai);
                $pjg= strlen($where);
                for($u= $i; $u < $pjg; $u++)
                    if($where[$u] === "$"){
                        $where= substr($where, 0, $u) .'"$perNilai"' .substr($where, $u+1);
                        $i= $u +strlen($perNilai) +2; //+3 karna ditambahi karakter '' yg mengapit $perNilai
                        //$where= $where_;
                  //  Debug::echoe($where);
                        break;
                    }
            }
            return "SELECT $attrib FROM $table WHERE $where;";
        }
        
        /**
         * Jika attrib yang dipilih banyak, maka penulisan input langsung
         * ditulis dg koma dalam string
         */
        function select(string $attrib): QueryBuilder {
            $attrib= $this->bersihkan($attrib);
            $this->attrib= $attrib;
            $this->perintah= "SELECT";
            return $this;
        }

        /**
         * Format $setAttrib:
         *      id = $ AND pass = $
         *      - $ untuk menandai tempat $nilai
         *      - Beri spasi antar elemen attrib, operator, dan nilai
         */

        function from(string $table): QueryBuilder {
            $table= $this->bersihkan($table);
            $this->table= $table;
            return $this;
        }

        function where(string $where, array $nilai): QueryBuilder {
            $where= $this->bersihkan($where);
            $where= $this->condition($where, $nilai);
            $this->where= "WHERE $where";
            return $this;
        }
        
        function update(string $table): QueryBuilder {
            $table= $this->bersihkan($table);
            $this->perintah= "UPDATE";
            $this->table= $table;
            return $this;
        }
        function set(string $setAttrib, array $nilai): QueryBuilder {
            $setAttrib= $this->bersihkan($setAttrib);
            $setAttrib= $this->condition($setAttrib, $nilai);
            $this->attrib= $setAttrib;
            return $this;
        }

        function insertInto(string $table): QueryBuilder{
            $table= $this->bersihkan($table);
            $this->perintah= "INSERT";
            $this->table= $table;
            return $this;
        }
        function value(array $attrib, array $nilai): QueryBuilder {
            //#1. Set #attribStr
            $attribStr= "(";
            $batas= count($attrib)-1;
            for($i = 0; $i < $batas; $i++){
                $attribStr .= $this->bersihkan($attrib[$i]) .", ";
            }
            $attribStr .= $this->bersihkan($attrib[$i]) .")";
            $this->attrib= $attribStr;

            //#2. Set #valueStr
            $valueStr= "VALUES(";
            for($i = 0; $i < $batas; $i++){
                $valueStr .= "$, ";
            }
            $valueStr .= "$)";

            $where= $this->condition($valueStr, $nilai);
            $this->where= $where;
            return $this;
        }

        function deleteFrom(string $table): QueryBuilder{
            $table= $this->bersihkan($table);
            $this->perintah= "DELETE";
            $this->table= $table;
            return $this;
        }

        private function condition(string $pola, array $nilai): string{
            $pola= $this->bersihkan($pola);
            $i= 0;
            foreach($nilai as $perNilai){
                $perNilai= $this->bersihkan($perNilai);
                $pjg= strlen($pola);
                for($u= $i; $u < $pjg; $u++)
                    if($pola[$u] === "$"){
                        $pola= substr($pola, 0, $u) .'"' .$perNilai .'"' .substr($pola, $u+1);
                        $i= $u +strlen($perNilai) +2; //+3 karna ditambahi karakter '' yg mengapit $perNilai
                        //$where= $where_;
                  //  Debug::echoe($where);
                        break;
                    }
            }
            return $pola;
        }

        function stringQuery(): string {
            if($this->perintah === "SELECT")
                return "$this->perintah $this->attrib FROM $this->table $this->where;";
            else if($this->perintah === "UPDATE")
                return "$this->perintah $this->table SET $this->attrib $this->where;";
            else if($this->perintah === "INSERT")
                return "$this->perintah INTO $this->table $this->attrib $this->where;";
            else if($this->perintah === "DELETE")
                return "$this->perintah FROM $this->table $this->where;";
        }

        function bersihkan(string $query): string {
            return str_replace(QueryBuilder::$charBahaya, "", $query);
        }
    }
?>