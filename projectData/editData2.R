###START###

#Use to check if a field has all unique values
length(unique(MOCK_DATA$Title))

#Use to display unique values (after test has been setup below)
unique(test$Genre)

#assign data frame to test show we don't break origianl dataset
test <- MOCK_DATA

#remove extra genres from field (so each book can only have one genre)
test$Genre <-sapply(strsplit(test$Genre, "[|]"), "[", 1)

#create authors tables using unique names found in test
authors <- test[names(test) %in% c("Author")]

#create IDs for them
authors$ID <- 1:1000

#swap first and second row
authors <- authors[c(2,1)]
names(authors) <- c("AuthorID","Name")

#create authors book table
authors_book <- data.frame(test$ISBN,1:1000)
names(authors_book) <- c("ISBN","AuthorID")

##START add extra authors so book can have more than one author

#create authors and IDS
extra_authors <- c("John Smith","Maxwell Smart","Bruce Wayne","Ash Ketchum", "Peter Parker")
extra_ids <- 1001:1005

df <- data.frame(extra_authors,extra_ids)
names(df) <- c("Name","AuthorID")

#add authors to authors table
authors <- rbind(authors,df)


#add authors to authors_book table (pick ISBM at random)
extra_isbn <- c(test$ISBN[1],test$ISBN[256],test$ISBN[999],test$ISBN[689],test$ISBN[456])

df2 <- data.frame(extra_isbn,extra_ids)
names(df2)<-c("ISBN","AuthorID")
authors_book <- rbind(authors_book,df2)

#have Peter Paker write another book
df3 <- data.frame(test$ISBN[77],1005)
names(df3) <- c("ISBN","AuthorID")

authors_book <- rbind(authors_book,df3)
authors_book$ISBN[length(authors_book$ISBN)]
##END create extra authors

#remove author column from test
test2 <- test[!names(test) %in% c("Author")]

#export as CSV
write.csv(test2,"Books.csv", row.names = F, col.names = T, quote = T)
write.csv(authors_bookQ,"Authors_Books.csv", row.names = F, col.names = T, quote = T)
write.csv(authorsQ,"Authors.csv", row.names = F, col.names = T, quote = T)

write.csv(unique(test$Genre),"Genres.csv", row.names = F, col.names = T, quote = F)



###END###