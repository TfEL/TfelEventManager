//
//  eventDataObject.h
//  TfEL Events
//
//  Created by Aidan Cornelius-Bell on 9/09/2014.
//  Copyright (c) 2014 Department for Education and Child Development. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface eventDataObject : NSObject

-(id)initWithJSONData:(NSDictionary*)data;

@property (assign) NSInteger eventidentifier;

@property (strong) NSString *eventName;

@property (strong) NSString *whenFrom;

@property (strong) NSString *whenTo;

@property (strong) NSString *whenStart;

@property (strong) NSString *where;

@property (strong) NSString *cost;

@property (strong) NSString *catering;

@property (strong) NSString *detailsURL;

@end
