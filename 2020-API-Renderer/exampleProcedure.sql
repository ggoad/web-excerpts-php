CREATE PROCEDURE `mpAdd_redacted__stop` (IN `dat` JSON, OUT `errString` TEXT)   BEGIN
		
	DECLARE obHolder JSON;
	DECLARE localErrString TEXT;
	DECLARE validateSuccess INT;
	DECLARE tempHolder TEXT;
	DECLARE tempTp TEXT;
DECLARE arrivalTime_valHolder TEXT;
		DECLARE comment_valHolder TEXT;
		DECLARE commuteComment_valHolder TEXT;
		DECLARE commuteType_valHolder TEXT;
		DECLARE commuteTypeExt_valHolder TEXT;
		DECLARE commuteVehicle_valHolder BIGINT UNSIGNED;
		DECLARE departureTime_valHolder TEXT;
		DECLARE mileagePool_valHolder BIGINT UNSIGNED;
		DECLARE pk_valHolder TEXT;
		DECLARE place_valHolder BIGINT UNSIGNED;
		
	jumpOut:BEGIN
	CALL rmf.TBL__redacted__stop_FILTERVALIDATE(dat, validateSuccess, 0);
	IF validateSuccess = 0 THEN 
		SET errString = 'Invalid dat';
		LEAVE jumpOut;
	END IF;

			SET tempHolder=JSON_UNQUOTE(JSON_EXTRACT(dat, '$.arrivalTime'));
			IF tempHolder IS NULL OR tempHolder = '' THEN
				SET errString= 'failed: the column arrivalTime was not provided';
				LEAVE jumpOut;
			END IF;
		
	SET arrivalTime_valHolder =JSON_UNQUOTE(JSON_EXTRACT(dat, '$.arrivalTime'));
SET tempTp=JSON_TYPE(arrivalTime_valHolder);
	IF tempTp = 'NULL' OR arrivalTime_valHolder='' OR arrivalTime_valHolder IS NULL THEN 
		SET arrivalTime_valHolder=NULL;
	ELSEIF  tempTp = 'BOOLEAN' THEN
		SET arrivalTime_valHolder=(arrivalTime_valHolder='true');
	END IF;

	SET comment_valHolder =JSON_UNQUOTE(JSON_EXTRACT(dat, '$.comment'));
SET tempTp=JSON_TYPE(comment_valHolder);
	IF tempTp = 'NULL' OR comment_valHolder='' OR comment_valHolder IS NULL THEN 
		SET comment_valHolder=NULL;
	ELSEIF  tempTp = 'BOOLEAN' THEN
		SET comment_valHolder=(comment_valHolder='true');
	END IF;

	SET commuteComment_valHolder =JSON_UNQUOTE(JSON_EXTRACT(dat, '$.commuteComment'));
SET tempTp=JSON_TYPE(commuteComment_valHolder);
	IF tempTp = 'NULL' OR commuteComment_valHolder='' OR commuteComment_valHolder IS NULL THEN 
		SET commuteComment_valHolder=NULL;
	ELSEIF  tempTp = 'BOOLEAN' THEN
		SET commuteComment_valHolder=(commuteComment_valHolder='true');
	END IF;

			SET tempHolder=JSON_UNQUOTE(JSON_EXTRACT(dat, '$.commuteType'));
			IF tempHolder IS NULL OR tempHolder = '' THEN
				SET errString= 'failed: the column commuteType was not provided';
				LEAVE jumpOut;
			END IF;
		
	SET commuteType_valHolder =JSON_UNQUOTE(JSON_EXTRACT(dat, '$.commuteType'));
SET tempTp=JSON_TYPE(commuteType_valHolder);
	IF tempTp = 'NULL' OR commuteType_valHolder='' OR commuteType_valHolder IS NULL THEN 
		SET commuteType_valHolder=NULL;
	ELSEIF  tempTp = 'BOOLEAN' THEN
		SET commuteType_valHolder=(commuteType_valHolder='true');
	END IF;

	SET commuteTypeExt_valHolder =JSON_UNQUOTE(JSON_EXTRACT(dat, '$.commuteTypeExt'));
SET tempTp=JSON_TYPE(commuteTypeExt_valHolder);
	IF tempTp = 'NULL' OR commuteTypeExt_valHolder='' OR commuteTypeExt_valHolder IS NULL THEN 
		SET commuteTypeExt_valHolder=NULL;
	ELSEIF  tempTp = 'BOOLEAN' THEN
		SET commuteTypeExt_valHolder=(commuteTypeExt_valHolder='true');
	END IF;

			
				SET obHolder=JSON_UNQUOTE(JSON_EXTRACT(dat, '$.commuteVehicle'));
				IF obHolder IS NOT NULL AND obHolder != '' AND IFNULL(@TBL__redacted__personalVehicles_RESOLVE_recDepth,0) < IFNULL(@TBL__redacted__personalVehicles_RESOLVE_recLimit,1) THEN 
					
					CALL rmf.TBL__redacted__personalVehicles_RESOLVE(obHolder, localErrString);
					
					IF localErrString IS NULL OR localErrString != 'empty' THEN 
						IF localErrString IS NULL OR localErrString = '' THEN 
							SET commuteVehicle_valHolder=JSON_UNQUOTE(JSON_EXTRACT(obHolder, '$.pk'));
						ELSE 
							SET errString=CONCAT('An object was indicated, but there was a problem resolving it: ', localErrString);
							LEAVE jumpOut;
						END IF;
					END IF;
				END IF;
				
			
	SET departureTime_valHolder =JSON_UNQUOTE(JSON_EXTRACT(dat, '$.departureTime'));
SET tempTp=JSON_TYPE(departureTime_valHolder);
	IF tempTp = 'NULL' OR departureTime_valHolder='' OR departureTime_valHolder IS NULL THEN 
		SET departureTime_valHolder=NULL;
	ELSEIF  tempTp = 'BOOLEAN' THEN
		SET departureTime_valHolder=(departureTime_valHolder='true');
	END IF;

			SET tempHolder=JSON_UNQUOTE(JSON_EXTRACT(dat, '$.mileagePool'));
			IF tempHolder IS NULL OR tempHolder = '' THEN
				SET errString= 'failed: the column mileagePool was not provided';
				LEAVE jumpOut;
			END IF;
		
				SET obHolder=JSON_UNQUOTE(JSON_EXTRACT(dat, '$.mileagePool'));
				IF obHolder IS NOT NULL AND obHolder != '' AND IFNULL(@TBL__redacted__mileagePool_RESOLVE_recDepth,0) < IFNULL(@TBL__redacted__mileagePool_RESOLVE_recLimit,1) THEN 
					
					CALL rmf.TBL__redacted__mileagePool_RESOLVE(obHolder, localErrString);
					
					IF localErrString = 'empty' THEN 
						SET errString='The required object was empty';
						LEAVE jumpOut;
					ELSEIF localErrString IS NOT NULL THEN
						SET errString=CONCAT('There was an error resolving the object ', localErrString);
						LEAVE jumpOut;
					END IF;
					
					SET mileagePool_valHolder=JSON_UNQUOTE(JSON_EXTRACT(obHolder, '$.pk'));
					
				ELSE 
					SET errString= 'could not parse object because parse limit was exceeded';
					LEAVE jumpOut;
				END IF;
			
	SET pk_valHolder =JSON_UNQUOTE(JSON_EXTRACT(dat, '$.pk'));
SET tempTp=JSON_TYPE(pk_valHolder);
	IF tempTp = 'NULL' OR pk_valHolder='' OR pk_valHolder IS NULL THEN 
		SET pk_valHolder=NULL;
	ELSEIF  tempTp = 'BOOLEAN' THEN
		SET pk_valHolder=(pk_valHolder='true');
	END IF;

			SET tempHolder=JSON_UNQUOTE(JSON_EXTRACT(dat, '$.place'));
			IF tempHolder IS NULL OR tempHolder = '' THEN
				SET errString= 'failed: the column place was not provided';
				LEAVE jumpOut;
			END IF;
		
				SET obHolder=JSON_UNQUOTE(JSON_EXTRACT(dat, '$.place'));
				IF obHolder IS NOT NULL AND obHolder != '' AND IFNULL(@_redacted__places_RESOLVE_recDepth,0) < IFNULL(@_redacted__places_RESOLVE_recLimit,1) THEN 
					
					CALL rmf._redacted__places_RESOLVE(obHolder, localErrString);
					
					IF localErrString = 'empty' THEN 
						SET errString='The required object was empty';
						LEAVE jumpOut;
					ELSEIF localErrString IS NOT NULL THEN
						SET errString=CONCAT('There was an error resolving the object ', localErrString);
						LEAVE jumpOut;
					END IF;
					
					SET place_valHolder=JSON_UNQUOTE(JSON_EXTRACT(obHolder, '$.pk'));
					
				ELSE 
					SET errString= 'could not parse object because parse limit was exceeded';
					LEAVE jumpOut;
				END IF;
			
	SET @TBL__redacted__stop_ADD_userVar='INSERT INTO _redacted_.stop (arrivalTime,comment,commuteComment,commuteType,commuteTypeExt,commuteVehicle,departureTime,mileagePool,pk,place) VALUES (?,?,?,?,?,?,?,?,?,?);';
	PREPARE TBL__redacted__stop_ADD_stmt FROM @TBL__redacted__stop_ADD_userVar;
	EXECUTE TBL__redacted__stop_ADD_stmt USING arrivalTime_valHolder,comment_valHolder,commuteComment_valHolder,commuteType_valHolder,commuteTypeExt_valHolder,commuteVehicle_valHolder,departureTime_valHolder,mileagePool_valHolder,pk_valHolder,place_valHolder;
	DEALLOCATE PREPARE TBL__redacted__stop_ADD_stmt;
	
	IF @@ERROR_COUNT > 0 THEN 
		SET errString='The insert was a failure';
		LEAVE jumpOut;
	END IF;

	SET errString='SUCCESS';
	END;

		END$$